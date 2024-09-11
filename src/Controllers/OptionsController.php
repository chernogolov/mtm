<?php

namespace Chernogolov\Mtm\Controllers;

use Chernogolov\Mtm\Models\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OptionsController extends \App\Http\Controllers\Controller
{
    //
    public function index(Request $request)
    {
        $post_data = $request->all();
        {
            if(isset($post_data['options']))
            {
                foreach ($post_data['options'] as $key => $value)
                {
                    $options = Options::updateOrCreate(
                        ['name' => $key],
                        ['title' => __($key), 'value' => $value, 'ordering' => 0]
                    );
                }
            }
        }

        $options = Options::getOptions();
        return view('mtm::options', ['data' => $options]);
    }
}
