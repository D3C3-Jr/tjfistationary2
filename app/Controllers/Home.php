<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['sidebar'] = 'home';
        return view('layout/main', $data);
    }
}
