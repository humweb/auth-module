<?php

namespace Humweb\Auth;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Routing\Router;

class AuthRouteServiceProvider extends RouteServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Humweb\Auth\Controllers';


    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace, 'middleware' => 'web'], function ($router) {
            require __DIR__.'/routes.php';
        });
    }
}
