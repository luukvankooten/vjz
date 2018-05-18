<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;

class BreadcrumbsComposer
{
    /*
     * @return void
     */
    public function compose(View $view)
    {
        $breadcrumps = $this->getCrumbs();
        $view->with(compact('breadcrumps'));
    }

    /**
     * Get the segments of url and turn in to array
     *
     * @return array
     */
    public function getCrumbs()
    {
        $crumbs[] = [
            'name' => 'Home',
            'url' => url('/'),
        ];

        if (!empty(request()->segments()))
        {
            $url = null;
            foreach (request()->segments() as $segment) {
                $url .= '/' . $segment;
                $crumbs[] = [
                    'name' => ucfirst($segment),
                    'url' => url($url),
                ];
            }
        }

        return $crumbs;
    }
}