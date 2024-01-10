<?php

namespace Wepa\Surveys\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Wepa\Surveys\Surveys
 */
class Surveys extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Wepa\Surveys\Surveys::class;
    }
}
