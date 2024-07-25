<?php

namespace Chernogolov\Mtm\Controllers;


class UserController extends CrudBaseController
{
    public $modelName = 'User';

    public function __construct()
    {
        parent::__construct();
    }
}