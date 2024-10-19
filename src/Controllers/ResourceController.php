<?php

namespace Chernogolov\Mtm\Controllers;

use Chernogolov\Mtm\Models\Resource;
use Chernogolov\Mtm\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


class ResourceController extends \App\Http\Controllers\Controller
{
    public $resource = [
    ];

    public function __construct()
    {
        $this->resource = config('mtm.resources');
        View::share('res', $this->resource);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        View::share('title', __('Resources'));
        $post_data = $request->all();
        if(isset($post_data['delete']) && !empty($post_data['delete']))
        {
            foreach ($post_data['delete'] as $id => $item) {
                $d = Resource::find($id);
                if($d)
                    $d->delete();
            }
        }

        $models = $this->getModels();

        $items = Resource::all()->keyBy('model_name');
        $resource = $this->resource;
        return view('mtm::' . $this->resource['view_prefix'] . '.index', compact('items', 'resource', 'models'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        View::share('title', __('Create resource'));
        $fields = collect([]);
        $pd = [];
//        foreach ($this->resource['editable_fields'] as $f)
//        {
//            if(isset($this->resource['fields'][$f]))
//                $fields->put($f, $this->resource['fields'][$f]);
//        }

        $post_data = $request->all();
        if(!isset($post_data['name']))
            abort('404');

        $fields = Schema::getColumnListing(Str::plural(Str::lower($post_data['name'])));
        return view('mtm::resource.create', ['fields' => $fields, 'name' => $post_data['name']]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post_data = $request->all();

        $data = $post_data['data'];
        $data['fields'] = $post_data['fields'];
//        $v_arr = [];
//        $request->validate($v_arr);

        $name = Str::lower($post_data['data']['model_name']);

        /* Create resourse permissions and check for creations base roles */
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $users = User::all();
        if($users->count() == 1)
        {
            if(!$users->first()->hasRole('Super-Admin'))
            {
                $sa_role = Role::create(['name' => 'Super-Admin']);
                $users->first()->assignRole('Super-Admin');
            }
        }

        if(!Role::where('name', 'Super-Admin')->first())
            $sa_role = Role::create(['name' => 'Super-Admin']);

        if(!Role::where('name', 'operator')->first())
            $sa_role = Role::create(['name' => 'operator']);

        Permission::create(['name' => 'list '.$name]);
        Permission::create(['name' => 'create '.$name]);
        Permission::create(['name' => 'edit '.$name]);
        Permission::create(['name' => 'delete '.$name]);

        Resource::create($data);


        return redirect()->route('resources.index')->with('success', $this->resource['one_name'] . __(' created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        View::share('title', __('Edit resource'));
        $resource = Resource::where('id', $id)->first();
        $fields = Schema::getColumnListing(Str::plural(Str::lower($resource->model_name)));
        return view('mtm::resource.edit', compact('resource', 'fields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resource $resource)
    {
        $request->validate([

        ]);

        $post_data = $request->all();
        $res = Resource::find($resource->id);

        if(isset($post_data['permissions']))
        {
            foreach($post_data['permissions'] as $permissionName => $roleNames)
            {
                $permission = Permission::where('name', $permissionName)->first();
                $permission->syncRoles($roleNames);
            }
        }

        if(isset($post_data['template']) && $post_data['template'])
        {
            if($post_data['template'] && $post_data['template'] !== '' && $request->hasFile('template'))
            {
                $ext = $request->file('template')->getClientOriginalExtension();
                $name = str_replace('.' . $ext, '', $request->file('template')->getClientOriginalName());

                $path = $request->file('template')->storeAs('templates', time() . '-' . Str::slug($name) . '-' . date('Y-m') . '.' . $ext, 'public');
                $res->template = [['name' => $name, 'file' => $path]];
            }
        }

        $res->ordering              = $request['data']['ordering'];
        $res->name                  = $request['data']['name'];
        $res->one_name              = $request['data']['one_name'];
        $res->route_prefix          = $request['data']['route_prefix'];
        $res->view_prefix           = $request['data']['view_prefix'];
        $res->model_name            = $request['data']['model_name'];
        $res->catalog_fields        = $request['data']['catalog_fields'];
        $res->editable_fields       = $request['data']['editable_fields'];
        $res->fields                = $request['fields'];
        $res->form_fields           = $request['data']['form_fields'];
        $res->api_fields            = $request['data']['api_fields'];
        $res->view_fields           = $request['data']['view_fields'];
        $res->export_fields         = $request['data']['export_fields'];

        if(isset($post_data['orm']) && $post_data['orm']['name'])
        {
            $f = (array) $res->fields;
            $o = $post_data['orm']['name'];
            if(isset($post_data['orm']['ext']))
                $ext = $post_data['orm']['ext'];
            else
                $ext = null;

            $f[$o] = (object) ['title' => $post_data['orm']['title'], 'type' => $post_data['orm']['type'], 'template' => $post_data['orm']['template'], 'ext' => $ext];
            $res->fields = (object) $f;
        }

        $res->save();

        return redirect()->route('resources.index')->with('status', 'Resource Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $resource = Resource::find($id);
        $name = Str::lower($resource['model_name']);
        $r = $resource->delete();
        Permission::where(['name' => 'list '.$name])->delete();
        Permission::where(['name' => 'create '.$name])->delete();
        Permission::where(['name' => 'edit '.$name])->delete();
        Permission::where(['name' => 'delete '.$name])->delete();
        return redirect()->route('resources.index')->with('status', 'Resource Delete Successfully');
    }


    function getModels(): Collection
    {
        $models = collect(File::allFiles(app_path()))
            ->map(function ($item) {
                $path = $item->getRelativePathName();
                $class = sprintf('\%s%s',
                    Container::getInstance()->getNamespace(),
                    strtr(substr($path, 0, strrpos($path, '.')), '/', '\\'));

                return $class;
            })
            ->filter(function ($class) {
                $valid = false;

                if (class_exists($class)) {
                    $reflection = new \ReflectionClass($class);
                    $valid = $reflection->isSubclassOf(Model::class) &&
                        !$reflection->isAbstract();
                }

                return $valid;
            });

        return $models->values();
    }

    public function clear($id)
    {
        $resource = Resource::where('id', $id)->first();
        $c_name = 'App\Models\\' . $resource->model_name;
        $c_name::query()->delete();

        return redirect(route('resources.edit', ['resource' => $id]));
    }
}
