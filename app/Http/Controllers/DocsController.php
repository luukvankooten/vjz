<?php

namespace App\Http\Controllers;

use App\Consult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocsController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'can:beeldbank']);
    }

    public function index()
    {
        $user = auth()->user()->id;
        $consults =  auth()->user()->consult()->get()->pluck('id')->toArray();
        $dirs = array_map(function ($id) use ($user) {
            $files = Storage::allFiles($user . '/consult/' . $id);
            if (!empty($files)) {
                return $files;
            }
        }, $consults);
        $dirs = array_filter($dirs);
        return view('main.file.index', compact('user', 'dirs'));
    }
}
