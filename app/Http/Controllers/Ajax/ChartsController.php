<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChartsController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'can:statestieken']);
    }

    public function data(Request $request)
    {
        $v = \validator($request->all(), [
            '' => '',
        ]);
    }
}
