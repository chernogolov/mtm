<?php

namespace Chernogolov\Mtm\Controllers;

use Chernogolov\Mtm\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Chernogolov\Mtm\Models\User;
use Illuminate\Support\Facades\View;

class BaseController extends \App\Http\Controllers\Controller
{
    public $resources = [
    ];

    public function __construct()
    {
        // Add resources into view
        $this->resources = config('mtm.resources');
    }

    public function dashboard()
    {
        View::share('title', __('Dashboard'));
        $view = 'dashboard';
        if(!view()->exists($view)){
            $view = 'mtm::dashboard';
        }
        return view($view);
    }

    public function welcome()
    {
        return view('mtm::welcome');
    }

}
