<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ValidateController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth:api', 'scope:app-login']);
    }

    public function validation()
    {
        return ['success'];
    }
}
