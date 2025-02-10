<?php

namespace Chernogolov\Mtm\Controllers;

use Chernogolov\Mtm\Imports\BaseImport;
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
use Chernogolov\Mtm\Models\User;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Support\Str;

class CrudBaseController extends \App\Http\Controllers\Controller
{
    private $order_by = 'created_at';
    private $order_by_direction = 'desc';

    public $resource = [];
    public $modelName;
    public $className;
    public $mtmUser;

    public function __construct()
    {
        /** Check user permissions */
        $this->mtmUser = User::find(Auth::user()->id);
        View::share('mtmUser', $this->mtmUser);
        if(!$this->mtmUser->hasRole('Super-Admin') && !Auth::user()->hasPermissionTo('list '.Str::lower($this->modelName)))
            abort(404);

        /** Get resource data from database */
        $this->resource = Resource::where('model_name', $this->modelName)->first();

        /** Generate model name */
        $this->className = '\App\Models\\' . $this->modelName;

        /** Set resource settings from string */
        $this->resource['editable_fields'] = explode(',', $this->resource['editable_fields']);
        $this->resource['catalog_fields'] = explode(',', $this->resource['catalog_fields']);
        $this->resource['view_fields'] = explode(',', $this->resource['view_fields']);
        $this->resource['export_fields'] = explode(',', $this->resource['export_fields']);
        if(strlen($this->resource['search_fields'])>1)
            $this->resource['search_fields'] = explode(',', $this->resource['search_fields']);
        $orm_fields = [];
        $fields = $this->resource->fields;
        foreach ($this->resource['catalog_fields'] as $f)
            if ($fields->$f->type == 'orm')
                $orm_fields[] = $f;

        $this->resource['orm_fields'] = $orm_fields;

        /** Delete unused fields */
//        unset($fields->id);
//        unset($fields->created_at);
//        unset($fields->updated_at);
        $this->resource->fields = $fields;

        View::share('title', $this->resource->name);
        View::share('res', $this->resource);
        View::share('fields', $fields);
    }

    /**
     * Display a listing of the resource.
     * @return View
     * @var $on_pages - items on page
     * @var $items - data intems with pagination
     * @var Resource $resource
     */
    public function index(Request $request)
    {
        $resource = $this->resource;

        $this->get_order($request);
        $itm = $this->className::orderBy($this->order_by, $this->order_by_direction);

        /** items on page from session */
        $this->get_items_on_page($request);

        /** Search by field */
        if(isset($request->search))
        {
            foreach ($request->search as $field => $phrase) {
                if(strlen($phrase) > 1)
                {
                    $phrase = $this->prepareSearchPhrase($phrase);

                    /** Search by relation OR Search by string field */
                    if($this->resource->fields->$field->type == 'orm')
                    {
                        $ext = json_decode($this->resource->fields->$field->ext);
                        if(isset($ext->fields) && !empty($ext->fields))
                        {
                            $arr = array_keys((array)$ext->fields);
                            $itm->whereHas($field, function (Builder $query) use($phrase, $arr) {
                                $query->where($arr[0], 'like', $phrase);
                            });
                        }
                    }
                    else
                        $itm->where($field, 'like', $phrase);
                }
            }
        }


        /** Add related data in resource */
        if (count($this->resource['orm_fields']) > 0)
            foreach ($this->resource['orm_fields'] as $of)
                $itm->with($of);

        /** Delete items */
        if (isset($request['delete_selected']) && !empty($request['delete'])) {
            foreach ($request['delete'] as $id => $item) {
                $d = $this->className::find($id);
                if ($d)
                    $d->delete();
            }
        }

        $on_pages = $request->session()->get('on_pages', 10);
        $items = $itm->paginate($on_pages);

        $view = 'mtm::' . $this->resource['view_prefix'] . '.index';
        if(!view()->exists($view)){
            $view = 'mtm::crud_base.index';
        }

        return view($view, compact('items', 'resource', 'on_pages'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create()
    {
        View::share('title', __('Create') . ' ' . $this->resource->name);
        if(!$this->mtmUser->hasRole('Super-Admin') && !Auth::user()->hasPermissionTo('create '.Str::lower($this->modelName)))
            abort(404);

        $fields = collect([]);
        foreach ($this->resource['editable_fields'] as $f) {
            if (isset($this->resource['fields']->$f))
                $fields->put($f, $this->resource['fields']->$f);
        }

        $view = 'mtm::' . $this->resource['view_prefix'] . '.create';
        if(!view()->exists($view)){
            $view = 'mtm::crud_base.create';
        }

        return view($view, compact('fields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     * @return Redirect
     */
    public function store(Request $request)
    {
        if(!$this->mtmUser->hasRole('Super-Admin') && !Auth::user()->hasPermissionTo('create '.Str::lower($this->modelName)))
            abort(404);

        $request->validate([

        ]);
        $insert_data = [];

        foreach ($this->resource->fields as $key => $item) {
            $f_name = 'store_' . $item->type;
            if (method_exists($this, $f_name) && in_array($key, $this->resource->editable_fields))
            {
                $insert_data[$key] = $this->$f_name($request, $item, $key);
            } else
                $insert_data[$key] = $request[$key];
        }

        $this->className::create($insert_data);

        return redirect()->route($this->resource['route_prefix'] . '.index')->with('success', $this->resource['one_name'] . __(' created successfully.'));
    }

    /**
     * Display the specified resource.
     * @return View
     */
    public function show($id)
    {
        View::share('title', __('Show') . ' ' . $this->resource->name);

        if(!$this->mtmUser->hasRole('Super-Admin') && !Auth::user()->hasPermissionTo('list '.Str::lower($this->modelName)))
            abort(404);

        $data = $this->className::find($id);

        if(!$data)
            abort(404);

        $view = $this->resource['view_prefix'] . '.show';
        if(!view()->exists($view)){
            $view = 'mtm::crud_base.show';
        }
        return view($view, compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return View
     */
    public function edit($id)
    {
        View::share('title', __('Edit') . ' ' . $this->resource->name);

        if(!$this->mtmUser->hasRole('Super-Admin') && !Auth::user()->hasPermissionTo('edit '.Str::lower($this->modelName)))
            abort(404);

        $data = $this->className::find($id);
        if(!$data)
            abort(404);

        $view = 'mtm::' . $this->resource['view_prefix'] . '.edit';
        if(!view()->exists($view)){
            $view = 'mtm::crud_base.edit';
        }
        return view($view, compact('data'));
    }

    /**
     * Update the specified resource in storage.
     * @return Redirect
     */
    public function update(Request $request, $id)
    {
        if(!$this->mtmUser->hasRole('Super-Admin') && !Auth::user()->hasPermissionTo('edit '.Str::lower($this->modelName)))
            abort(404);

        $request->validate([

        ]);

        $res = $this->className::where('id', $id)->get()->first();
        if(!$res)
            abort(404);

        foreach ($this->resource->fields as $key => $item)
        {
            if(isset($request[$key]) || isset($request['new_' . $key]) || isset($request['del_' . $key])) {
                $f_name = 'update_' . $item->type;
                if(method_exists($this, $f_name) && in_array($key, $this->resource->editable_fields))
                {
                    $r = $this->$f_name($request, $item, $key, $res);
                    if($r)
                    {
                        if($item->type == 'orm')
                            $key = $key . '_id';

                        $res->$key = $r;
                    }

                }
                else
                    $res->$key = $request[$key];
            }
        }

        $res->save();

        return redirect()->route($this->resource['route_prefix'] . '.index')->with('status', 'Resource Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     * @return Redirect
     */
    public function destroy($id)
    {
        if(!$this->mtmUser->hasRole('Super-Admin') && !Auth::user()->hasPermissionTo('delete '.Str::lower($this->modelName)))
            abort(404);

        $data = $this->className::find($id)->delete();
        return redirect()->route($this->resource['route_prefix'] . '.index')->with('status', 'Resource Delete Successfully');
    }

    /**
     * Generate Docx document from item
     * @return Response MS Word document
     */

    public function template($id, $template_index)
    {
        $data = $this->className::find($id);
        $template = $this->resource->template[$template_index];

        $templateProcessor = new TemplateProcessor(asset('storage/' . $template->file));

        /** @var  $vars - Variables on the template document */
        $vars = $templateProcessor->getVariables();
        foreach ($vars as $var)
        {
            if($var == 'datestamp')
                $templateProcessor->setValue($var, date('Y-m-d'));
            if($var == 'timestamp')
                $templateProcessor->setValue($var, date('Y-m-d h:i:s'));

            if(isset($this->resource->fields->$var)) {
                $field = $this->resource->fields->$var;
                if($field->type == 'gallery') {
                    $arr = [];
                    $d = json_decode($data->$var);
                    if(is_array($d) && !empty($d)) {
                        foreach (json_decode($data->$var) as $k => $image)
                            $arr[][$var] = '${' . $var.$k . '}';

                        $templateProcessor->cloneRowAndSetValues($var, $arr);
                        foreach (json_decode($data->$var) as $k => $image)
                            $templateProcessor->setImageValue($var.$k, ['path' => asset('storage' . $image), 'width' => 650, 'height' => 650, 'ratio' => true]);
                    }
                }
                elseif($field->type == 'list') {
                    $ext = json_decode($field->ext);
                    $v = $data->$var;
                    if(isset($ext->list))
                        $templateProcessor->setValue($var, $ext->list->$v);
                }
                else
                    $templateProcessor->setValue($var, html_entity_decode(strip_tags($data->$var)));
            }
        }

        /** Save temp document & download */
        if(!Storage::disk('public')->exists('/templates/temp/'))
            Storage::disk('public')->makeDirectory('/templates/temp/'); //creates directory

        $pathToSave = storage_path('app/public' . '/templates/temp/' . Auth::user()->id. '.docx');
        $templateProcessor->saveAs($pathToSave);

        return response()->download($pathToSave);
    }

    /**
     * Clone item.
     * @return Redirect
     */
    public function cloning($id)
    {
        if(!$this->mtmUser->hasRole('Super-Admin') && !Auth::user()->hasPermissionTo('edit '.Str::lower($this->modelName)))
            abort(404);

        $data = $this->className::find($id)->replicate()->save();
        return redirect()->route($this->resource['route_prefix'] . '.index')->with('status', 'Cloning successfully');
    }

    /**
     * Store image on the Disk.
     * @return (string) Image path
     */
    public function save_image_on_disk($resource)
    {
        $thumbnails = true;
        $optimize = true;

        /**  Save original image */
        $path = '/images/' . Str::plural($this->resource['route_prefix']) . '/' . date('Y-m', ) . '/';

        if(!Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path); //creates directory
        }

        $image = Image::read($resource);
        $imageName = time().'-'.$resource->getClientOriginalName();

        $destinationPath = storage_path('app/public' . $path);

        /** Optimization image */
        if($optimize)
        {
            $height = $image->height();
            $width = $image->width();
            if($height > 900)
                $image->scaleDown(height: 900);

            if($width > 1200)
                $image->scaleDown(width: 1200);

            $extension = $resource->getClientOriginalExtension();
            $imageName = str_replace($extension, 'jpg', $imageName);
            $image->save($destinationPath.$imageName, quality: 80, progressive: true);

        }
        else
            $image->save($destinationPath.$imageName);

        /** Create and save thumbnails */
        if($thumbnails)
        {
            $image->cover(150, 150);
            $thumbName = 't_' . $imageName;
            $image->save($destinationPath.$thumbName);
        }

        return $path . $imageName;
    }

    /**
     * Store file on the Disk.
     * @return (string) File path
     */
    public function save_file_on_disk($resource)
    {
        $path = '/files/' . Str::plural($this->resource['route_prefix']) . '/' . date('Y-m', );

        if(!Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path); //creates directory
        }

        $name = time().'-' . Str::slug($resource->getClientOriginalName());
        $extension = $resource->getClientOriginalExtension();
        $name = str_replace($extension, '', $name) . '.' . $extension;

        $path = $resource->storeAs($path, $name, 'public');

        return $path;
    }

    /**
     * Gallery save helper.
     * @return images[]
     */
    public function update_gallery($request, $item, $key, $res)
    {
        $json_files = [];
        if(isset($request[$key]))
            $json_files = $request[$key];

        if($request->hasFile('new_' . $key))
            foreach ($request->file('new_' . $key) as $file) {
                $json_files[] = $this->save_image_on_disk($file, $item->ext);
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
//    public function update_text_editor($request, $item, $key)
//    {
//
//    }

    /**
     * Files save helper.
     * @return files[]
     */
    public function update_files($request, $item, $key, $res)
    {
        $json_files = [];
        if(isset($request[$key]))
            $json_files = $request[$key];

        if($request->hasFile('new_' . $key))
            foreach ($request->file('new_' . $key) as $file) {
                $json_files[] = $this->save_file_on_disk($file, $item->ext);
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

    /**
     * User save helper.
     * @return User id
     */
    public function update_user($request, $item, $key, $res)
    {
        return Auth::user()->id;
    }

    /**
     * Relation save helper.
     * @return key or save relation
     */
    public function update_orm($request, $item, $key, $res)
    {
        $k = $key . '_id';
        if(isset($res->$k) || $res->$k == null)
            return $request[$key];
        else
        {
            $m = 'App\Models\\' . ucfirst($key);
            $md = $m::where('id', $request[$key])->first();
            if($md)
            {
                $kk = $this->modelName . '_id';
                $md->$kk = $res->id;
                $md->save();
            }

            return false;
        }
    }

    /**
     * Password save helper.
     * @return hashed password
     *
     */
    public function update_passwd($request, $item, $key, $res)
    {
        if($request[$key] != null)
            return Hash::make($request[$key]);
    }

    /**
     * Export resources to Excel
     * @return xlsx file
     */
    public function export(Request $request)
    {
        $data = $this->className::get();

//        return view($this->resource['view_prefix'] . '.export', compact('data'));
        return Excel::download(new BaseExport($this->resource['view_prefix'], $this->resource, $data), strtolower(Str::plural($this->modelName)) . '-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Import resources from Excel
     */
    public function import(Request $request)
    {
        $data = $this->className::get();

        $post_data = $request->all();
        if (isset($post_data['file'])) {
            Excel::import(new BaseImport($this->resource['view_prefix'], $this->resource, $data), $request->file('file'));
            return redirect()->route($this->resource['route_prefix'] . '.index')->with('status', 'Import successfully');
        }
    }

    /**
     * Return saved gallery data.
     * $return gallery links[]
     */
    public function store_gallery($request, $item, $key)
    {
        $json_files = [];
        if ($request->hasFile($key))
        {
            foreach ($request->file($key) as $file)
            {
                $json_files[] = $this->save_image_on_disk($file, $item->ext);
            }
        }
        return json_encode($json_files);
    }

    /**
     * Return saved gallery data.
     * $return files links[]
     */
    public function store_files($request, $item, $key)
    {
        $json_files = [];
        if ($request->hasFile($key)) {
            foreach ($request->file($key) as $file) {
                $json_files[] = $this->save_file_on_disk($file, $item->ext);
            }
        }
        return json_encode($json_files);
    }

    /**
     * Return saved gallery data.
     * $return User id
     */
    public function store_user($request, $item, $key)
    {
        return Auth::user()->id;
    }

    public function get_order($request)
    {
        if(isset($this->resource->fields->rating))
        {
            $this->order_by = 'rating';
            $this->order_by_direction = 'desc';
        }

        if(isset($this->resource->fields->ordering))
        {
            $this->order_by = 'rating';
            $this->order_by_direction = 'asc';
        }

        if(isset($this->resource->order_by))
            $this->order_by = $this->resource->order_by;

        if(isset($this->resource->order_by_direction))
            $this->order_by_direction = $this->resource->order_by_direction;

        if(isset($request['order_by']))
            $this->order_by = $request['order_by'];

        if(isset($request['order_by_direction']))
            $this->order_by_direction = $request['order_by_direction'];

        View::share('order_by', $this->order_by);
        View::share('order_by_direction', $this->order_by_direction);
    }

    public function get_items_on_page($request)
    {
        if (isset($request['on_pages']))
        {
            $request->session()->put('on_pages', $request['on_pages']);
            $this->on_pages = $request['on_pages'];

        }

        $this->on_pages = $request->session()->get('on_pages');

        View::share('on_pages', $this->on_pages);
    }

    public function prepareSearchPhrase($phrase)
    {
        $phrase = str_replace([' ', ','], '%', $phrase);
        return '%' . $phrase . '%';
    }
}
