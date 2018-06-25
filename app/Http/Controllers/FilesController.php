<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request, $path)
    {
        if (!Storage::exists($path) &&
            \Gate::denies('show-file', $request->segment(2)))
        {
            abort(404);
        }

        ini_set('memory_limit','256M');
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        switch ($extension) {
            case 'jpeg':
            case 'png':
            case 'jpg':
                $image = \Image::make(storage_path('/app/'. $path));
                return $image->response($extension);
                break;
            default:
                return Storage::download($path);
                break;
        }
    }
}
