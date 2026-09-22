<?php

namespace App\Controllers\Site;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        return view('site/home', ['title' => lang('App.appName')]);
    }
}
