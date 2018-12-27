<?php

namespace LaravelGelf;

use Monolog\Logger;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class LaravelGelfProvider extends ServiceProvider
{
    /**
     * Register
     */
    public function register()
    {
        $this->app['log']->extend('laravel-gelf', function (Container $app, array $config) {
            $laravel_gelf = new LaravelGelf($config);

            return new Logger($this->parseChannel($config), [
                new LaravelGelfHandler($laravel_gelf->level(), $laravel_gelf->bubble(), $laravel_gelf)
            ]);
        });
    }
}
