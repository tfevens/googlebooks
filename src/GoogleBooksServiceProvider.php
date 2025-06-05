<?php

namespace Tfevens\GoogleBooks;

use Illuminate\Support\ServiceProvider;
use tfevens\GoogleBooks\Services\GoogleBooksService;

class GoogleBooksServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/googlebooks.php', 'google-books');

        $this->app->singleton(GoogleBooksService::class, function ($app) {
            return new GoogleBooksService(
                $app['config']['google-books.api_key'],
                $app['config']['google-books.base_url']
            );
        });

        $this->app->alias(GoogleBooksService::class, 'google-books');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/googlebooks.php' => config_path('googlebooks.php'),
            ], 'google-books-config');
        }
    }
}
