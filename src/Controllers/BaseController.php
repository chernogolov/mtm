<?php

namespace Chernogolov\Mtm\Controllers;

use Chernogolov\Mtm\Models\Resource;
use Illuminate\Http\Request;


class BaseController extends \App\Http\Controllers\Controller
{
    public $resources = [
    ];

    public function __construct()
    {
        // Add resources into view
        $this->resources = config('resources');

    }

    public function dashboard()
    {
        return view('dashboard');
    }

}
