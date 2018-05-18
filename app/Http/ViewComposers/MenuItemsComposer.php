<?php
namespace App\Http\ViewComposers;

use Gate;
use Illuminate\View\View;

class MenuItemsComposer
{

    public $menuItems;

    public $routes;

    /**
     * MenuItemsComposer constructor.
     */
    public function __construct()
    {
        $this->routes = \Route::getRoutes()->getRoutes();
    }

    /*
     * @return void
     */
    public function compose(View $view)
    {
        $menuitems = $this->setMenuItems();
        $view->with(compact('menuitems'));
    }

    /**
     * Get the segments of url and turn in to array
     *
     * @return array
     */
    public function setMenuItems()
    {

        foreach ($this->routes as $route) {
            if (in_array('GET', $route->methods) &&
                isset($route->action['icon']) &&
                Gate::allows($this->setName($route))
            ) {
                $this->menuItems[] = [
                    'uri' => $route->uri,
                    'icon' => $route->action['icon'],
                    'name' => $this->setName($route),
                    'expanded' => $this->expanded($route),
                ];
            }
        }

        return $this->menuItems;
    }

    /**
     * Check if has alternative name.
     *
     * @param $route
     * @return bool
     */
    public function hasName($route)
    {
        return isset($route->action['as']);
    }

    /**
     * Set the name for menu item.
     *
     * @param $route
     * @return string
     */
    public function setName($route)
    {
        return $this->hasName($route)? $route->action['as'] : preg_replace("%.*?\/%", '', $route->uri);
    }

    /**
     * For submenu items.
     *
     * @param $route
     * @return array|null
     */
    public function expanded($route)
    {
        if (isset($route->action['prefix'])) {
            foreach ($this->routes as $prefixRoute) {
                if (
                    in_array('GET', $prefixRoute->methods) &&
                    $route->action['prefix'] == $prefixRoute->action['prefix'] &&
                    $route->uri !== $prefixRoute->uri &&
                    !preg_match("/[{.*?}]/", $prefixRoute->uri) &&
                    Gate::allows($this->setName($prefixRoute))
                ) {
                    $item[] = [
                        'name' => $this->setName($prefixRoute),
                        'url' => $prefixRoute->uri,
                    ];
                }
            }
        }
        return isset($item)? $item : null;
    }
}