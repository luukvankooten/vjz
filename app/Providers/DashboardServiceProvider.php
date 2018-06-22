<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;

class DashboardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     * For all Dashboard thinks.
     *
     * @return void
     */
    public function boot(ViewFactory $view)
    {
        $view->composer('*', 'App\Http\ViewComposers\AuthComposer');
        View::composers([
            'App\Http\ViewComposers\BreadcrumbsComposer' => '*',
            'App\Http\ViewComposers\MenuItemsComposer' => '*',
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
