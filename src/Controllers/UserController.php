<?php

namespace Chernogolov\Mtm\Controllers;
use Illuminate\Http\Request;


class UserController extends CrudBaseController
{
    public $modelName = 'User';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Update the specified resource in storage.
     * @return Redirect
     */
    public function update(Request $request, $id)
    {
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
                        $res->$key = $r;
                }
                else
                    $res->$key = $request[$key];
            }
        }

        if(isset($request['roles']))
            $res->syncRoles($request['roles']);

        $res->save();

        return redirect()->route($this->resource['route_prefix'] . '.index')->with('status', 'Resource Updated Successfully');
    }


}
