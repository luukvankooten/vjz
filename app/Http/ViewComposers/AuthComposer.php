<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class AuthComposer
{
    public function compose(View $view)
    {
        if (auth()->check())  {
            $path = auth()->user()->id . '/picture.png';
            $view->with('picture', asset((\Storage::disk('public')->exists($path)) ? '/storage/' . $path : 'images/dummy-profile-pic.png'));
        }
    }
}