<?php

namespace Chernogolov\Mtm\Controllers;

use Chernogolov\Mtm\Models\Resource;
use Illuminate\Http\Request;

class FormController extends \App\Http\Controllers\Controller
{
    //

    public function form(Request $request, $resource)
    {
        $resource = Resource::where('model_name', ucfirst($resource))->first();

        if(!$resource || strlen($resource->form_fields) < 1)
            abort(404);

        return view($resource->view_prefix . '.form', compact('resource'));
    }
}
