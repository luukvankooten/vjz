<?php

namespace App\Http\Controllers;

use App\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        return view('main.settings.index', compact('user'));
    }

    public function update(Request $request)
    {
        $v = Validator::make($request->all(), [
            'password' => 'sometimes|string|min:6|confirmed',
            'password_old' => 'required_with:password|string|min:6',
            'picture' => 'sometimes|file|image|max:1000',
        ]);

        if ($request->has('password_old') && !(\Hash::check($request->get('password_old'), auth()->user()->password))) {
            return redirect()->back()->withErrors(['password_old' => ['Is niet het zelfde als huidige wachtwoord.']]);
        }

        if ($request->ajax()) {
            if ($v->fails()) {
                return $v->errors();
            }
            return ['success'];
        } else {
            $v->validate();
        }

        if ($request->has('picture')) {
            $path = auth()->user()->id;
            if (Storage::disk('local')->exists($path . '/picture.png')) {
                Storage::delete($path . '/picture.png');
            }
            $file = $request->file('picture');
            if ($file->extension() !== 'png') {
                $data = 'data:image/png;base64,' . base64_encode(file_get_contents($file));
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
                file_put_contents($file, $data);
            }

            Storage::disk('public')->putFileAs($path, $file, 'picture.png');
        }

        if ($request->has('password')) {
            $user = \Auth::user();
            $user->password = \Hash::make($request->get('password'));
            $user->save();
        }

        return redirect()->back()->with("status","Met succes gewijzigd.");
    }
}
