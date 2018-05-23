<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:o2auth');
    }

    public function index()
    {
        return view('main.server.index');
    }


}
