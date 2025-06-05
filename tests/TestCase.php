<?php

namespace Tfevens\GoogleBooks\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Tfevens\GoogleBooks\GoogleBooksServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            GoogleBooksServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        
    }
}
