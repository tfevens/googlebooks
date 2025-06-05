<?php

namespace Tfevens\GoogleBooks\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \tfevens\GoogleBooks\GoogleBooks
 */
class GoogleBooks extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \tfevens\GoogleBooks\GoogleBooks::class;
    }
}
