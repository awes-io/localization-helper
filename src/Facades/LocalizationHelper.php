<?php

namespace AwesIO\LocalizationHelper\Facades;

use Illuminate\Support\Facades\Facade;

class LocalizationHelper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'localizationhelper';
    }
}
