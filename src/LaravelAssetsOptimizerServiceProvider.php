<?php

namespace LaravelAssetsOptimizer;

use Illuminate\Support\ServiceProvider;

class LaravelAssetsOptimizerServiceProvider extends ServiceProvider
{
	protected $commands = [
        LaravelAssetsOptimizerCommand::class,
    ];

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/assets.php' => config_path('assets.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/assets.php', 'assets');

		$this->commands($this->commands);

    }
}