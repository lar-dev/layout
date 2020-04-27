<?php

namespace Lar\Layout;

use Illuminate\Support\Facades\Facade as FacadeIlluminate;

/**
 * Class Facade
 * 
 * @package Lar
 */
class Facade extends FacadeIlluminate
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Layout::class;
    }
}
