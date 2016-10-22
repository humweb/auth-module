<?php

namespace Humweb\Auth\Groups;

use Illuminate\Support\ServiceProvider;

class GroupsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
    }


    /**
     * Register services
     */
    public function register()
    {
        $this->app['modules']->put('groups', [
            'menu' => [
                'auth' => [
                    [
                        'label' => 'Groups',
                        'route' => 'get.groups',
                    ],
                ],
            ],
        ]);
    }
}
