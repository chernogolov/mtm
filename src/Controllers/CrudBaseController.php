<?php

namespace Chernogolov\Mtm\Controllers;

use Chernogolov\Mtm\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use Chernogolov\Mtm\Exports\BaseExport;
use \PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

class CrudBaseController extends \App\Http\Controllers\Controller
{
    public $resource = [];
    public $m_name;
    public $c_name;

    public function __construct()
    {
        $this->resource = Resource::where('model_name', $this->m_name)->first();
        $this->c_name = 'App\Models\\' . $this->m_name;
        $this->resource['editable_fields'] = explode(',', $this->resource['editable_fields']);
        $this->resource['catalog_fields'] = explode(',', $this->resource['catalog_fields']);
        $this->resource['view_fields'] = explode(',', $this->resource['view_fields']);
        $this->resource['export_fields'] = explode(',', $this->resource['export_fields']);
        $orm_fields = [];
        $fields = $this->resource->fields;
        foreach ($this->resource['catalog_fields'] as $f)
            if($fields->$f->type == 'orm')
                $orm_fields[] = $f;

        $this->resource['orm_fields'] = $orm_fields;
        unset($fields->id);
        unset($fields->created_at);
        unset($fields->updated_at);
        $this->resource->fields = $fields;
        View::share('res', $this->resource);
        View::share('fields', $fields);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $resource = $this->resource;
        $post_data = $request->all();

        /* items on page */
        if(isset($post_data['on_pages']))
            session(['on_pages' => $post_data['on_pages']]);
        $on_pages = $request->session()->get('on_pages', 10);

        if(isset($post_data['delete']) && !empty($post_data['delete']))
        {
            foreach ($post_data['delete'] as $id => $item) {
                $d = $this->c_name::find($id);
                if($d)
                    $d->delete();
            }
        }
        if(isset($post_data['excel']))
        {
            $exp_name = 'App\Exports\\' . Str::plural($this->m_name) . 'Export';
            $data = $this->c_name::get();
//            return view('crud_base.export', [
//                'res' => $this->resource,
//                'data' => $data
//            ]);
            return Excel::download(new BaseExport($this->resource['view_prefix'], $resource, $data), strtolower(Str::plural($this->m_name)) . '-' . date('Y-m-d') . '.xlsx');
        }

        $itm = $this->c_name::latest();

        if(count($this->resource['orm_fields'])>0)
            foreach ($this->resource['orm_fields'] as $of)
                $itm->with($of);


        $items = $itm->paginate(200);


        return view($this->resource['view_prefix'] . '.index', compact('items', 'resource', 'on_pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $fields = collect([]);
        foreach ($this->resource['editable_fields'] as $f)
        {
            if(isset($this->resource['fields']->$f))
                $fields->put($f, $this->resource['fields']->$f);
        }
        return view($this->resource['view_prefix'] . '.create', compact('fields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $v_arr = [];
        $files = [];
        $paths = [];
        $fields = collect([]);
        $insert_data = [];
        $post_data = $request->all();


        foreach ($this->resource->fields as $key => $item)
        {
            if(isset($post_data[$key]))
            {
                if($item->type == 'gallery')
                {
                    $json_files = [];
                    if ($request->hasFile($key))
                    {
                        foreach ($request->file($key) as $file) {
                            $json_files[] = $this->storeImage($file, $item->ext);
                        }
                    }
                    $insert_data[$key] = json_encode($json_files);
                }
                elseif($item->type == 'files')
                {
                    $json_files = [];
                    if ($request->hasFile($key))
                    {
                        foreach ($request->file($key) as $file) {
                            $json_files[] = $this->storeFile($file, $item->ext);
                        }
                    }
                    $insert_data[$key] = json_encode($json_files);
                }
                elseif($item->type == 'user')
                    $insert_data[$key] = Auth::user()->id;
                else
                    $insert_data[$key] = $post_data[$key];
            }
        }

        $this->c_name::create($insert_data);

        return redirect()->route($this->resource['route_prefix'].'.index')->with('success', $this->resource['one_name'] . __(' created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->c_name::find($id);
        if(!$data)
            abort(404);
        return view($this->resource['view_prefix'] . '.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $data = $this->c_name::find($id);
        if(!$data)
            abort(404);
        return view($this->resource['view_prefix'] . '.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([

        ]);

        $post_data = $request->all();

        $res = $this->c_name::where('id', $id)->get()->first();
        if(!$res)
            abort(404);

        foreach ($this->resource->fields as $key => $item)
        {
            if(array_key_exists('answer', $post_data) || isset($post_data['new_' . $key]) || isset($post_data['del_' . $key]))
            {
                $f_name = 'update_' . $item->type;
                if(method_exists($this, $f_name) && in_array($key, $this->resource->editable_fields))
                {
                    $r = $this->$f_name($request, $item, $key, $res);
                    if($r)
                        $res->$key = $r;
                }
                else
                    $res->$key = $post_data[$key];
            }
        }
        $res->save();

        return redirect()->route($this->resource['route_prefix'] . '.index')->with('status', 'Resource Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = $this->c_name::find($id)->delete();
        return redirect()->route($this->resource['route_prefix'] . '.index')->with('status', 'Resource Delete Successfully');
    }

    public function template($id, $template_index)
    {
        $data = $this->c_name::find($id);
        $template = $this->resource->template[$template_index];
        $templateProcessor = new TemplateProcessor(asset('storage/' . $template->file));
        $vars = $templateProcessor->getVariables();
        foreach ($vars as $var)
        {
            if($var == 'datestamp')
                $templateProcessor->setValue($var, date('Y-m-d'));
            if($var == 'timestamp')
                $templateProcessor->setValue($var, date('Y-m-d h:i:s'));

            if(isset($this->resource->fields->$var))
            {
                $field = $this->resource->fields->$var;
                if($field->type == 'gallery')
                {
                    $arr = [];
                    $d = json_decode($data->$var);
                    if(is_array($d) && !empty($d))
                    {
                        foreach (json_decode($data->$var) as $k => $image) {
                            $arr[][$var] = '${' . $var.$k . '}';
                        }
                        $templateProcessor->cloneRowAndSetValues($var, $arr);
                        foreach (json_decode($data->$var) as $k => $image) {
                            $templateProcessor->setImageValue($var.$k, ['path' => asset('storage' . $image), 'width' => 650, 'height' => 650, 'ratio' => true]);
                        }
                    }
                }
                elseif($field->type == 'list')
                {
                    $ext = json_decode($field->ext);
                    $v = $data->$var;
                    if(isset($ext->list))
                        $templateProcessor->setValue($var, $ext->list->$v);
                }
                else
                {
                    $templateProcessor->setValue($var, html_entity_decode(strip_tags($data->$var)));
                }
            }
        }

        if(!Storage::disk('public')->exists('/templates/temp/')) {
            Storage::disk('public')->makeDirectory('/templates/temp/'); //creates directory
        }

        $pathToSave = storage_path('app/public' . '/templates/temp/' . Auth::user()->id. '.docx');
        $templateProcessor->saveAs($pathToSave);

        return response()->download($pathToSave);
    }

    public function cloning($id)
    {
//        $i = 0;
//        while($i < 1000)
//        {
            $data = $this->c_name::find($id)->replicate()->save();
//            $i++;
//        }

        return redirect()->route($this->resource['route_prefix'] . '.index')->with('status', 'Cloning successfully');
    }

    public function storeImage($resource)
    {
        $thumbnails = true;
        $optimize = true;

        //save original image
        $path = '/images/' . Str::plural($this->resource['route_prefix']) . '/' . date('Y-m', ) . '/';

        if(!Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path); //creates directory
        }

        $image = Image::read($resource);
        $imageName = time().'-'.$resource->getClientOriginalName();

        $destinationPath = storage_path('app/public' . $path);

        if($optimize)
        {
            $height = $image->height();
            $width = $image->width();
            if($height > 900)
                $image->scaleDown(height: 900);

            if($width > 1200)
                $image->scaleDown(width: 1200);

            $ext = $resource->getClientOriginalExtension();
            $imageName = str_replace($ext, 'jpg', $imageName);
            $image->save($destinationPath.$imageName, quality: 80, progressive: true);

        }
        else
            $image->save($destinationPath.$imageName);

//        echo "<img src='".asset('storage/' . $path . $imageName)."'>";

        if($thumbnails)
        {
            $image->cover(150, 150);
            $thumbName = 't_' . $imageName;
            $image->save($destinationPath.$thumbName);

//            echo "<img src='".asset('storage/' . $path . $thumbName)."'>";
        }
        return $path . $imageName;
    }
    public function storeFile($resource)
    {

        //save original image
        $path = '/files/' . Str::plural($this->resource['route_prefix']) . '/' . date('Y-m', );

        if(!Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path); //creates directory
        }

        $name = time().'-' . Str::slug($resource->getClientOriginalName());
        $ext = $resource->getClientOriginalExtension();
        $name = str_replace($ext, '', $name) . '.' . $ext;

        $path = $resource->storeAs($path, $name, 'public');

        return $path;
    }
    public function update_gallery($request, $item, $key, $res)
    {
        $json_files = [];
        if(isset($request[$key]))
            $json_files = $request[$key];

        if($request->hasFile('new_' . $key))
            foreach ($request->file('new_' . $key) as $file) {
                $json_files[] = $this->storeImage($file, $item->ext);
            }

        if(isset($request['del_' . $key]))
            foreach ($request['del_' . $key] as $file) {
                Storage::disk('public')->delete($file);
                $arr = explode('/', $file);
                $n = array_pop($arr);
                $file = str_replace($n, 't_'.$n, $file);
                Storage::disk('public')->delete($file);
            }

       return json_encode(array_values($json_files));

    }
//
//    public function update_list($request, $item, $key)
//    {
//
//    }
    public function update_text_editor($request, $item, $key)
    {
        if($request[$key])
            return $request[$key];
        else
        {
            return " ";
        }
    }
    public function update_files($request, $item, $key, $res)
    {
        $json_files = [];
        if(isset($request[$key]))
            $json_files = $request[$key];

        if($request->hasFile('new_' . $key))
            foreach ($request->file('new_' . $key) as $file) {
                $json_files[] = $this->storeFile($file, $item->ext);
            }

        if(isset($request['del_' . $key]))
        {
            foreach ($request['del_' . $key] as $file) {
                Storage::disk('public')->delete($file);
                $arr = explode('/', $file);
                $n = array_pop($arr);
                $file = str_replace($n, 't_'.$n, $file);
                Storage::disk('public')->delete($file);
            }
        }
        return json_encode(array_values($json_files));
    }
    public function update_user($request, $item, $key, $res)
    {
        return Auth::user()->id;
    }
    public function update_orm($request, $item, $key, $res)
    {
        $k = $key . '_id';
        if(isset($res->$k))
            return $request[$key];
        else
        {
            $m = 'App\Models\\' . ucfirst($key);
            $md = $m::where('id', $request[$key])->first();
            if($md)
            {
                $kk = $this->m_name . '_id';
                $md->$kk = $res->id;
                $md->save();
            }

            return false;
        }
    }
    public function update_passwd($request, $item, $key, $res)
    {
        if($request[$key] != null)
            return Hash::make($request[$key]);
    }
}
