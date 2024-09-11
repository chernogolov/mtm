<?php

namespace Chernogolov\Mtm\Controllers;

use Chernogolov\Mtm\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Chernogolov\Mtm\Models\User;

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
        return view('mtm::dashboard');
    }

    public function welcome()
    {
        return view('mtm::welcome');
    }

}
