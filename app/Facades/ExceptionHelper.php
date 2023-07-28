<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void make(string $message, int $statusCode)
 * */
class ExceptionHelper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'exceptionHelper';
    }
}
