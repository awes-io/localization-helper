<?php

namespace AwesIO\LocalizationHelper\Tests;

use AwesIO\LocalizationHelper\LocalizationHelperServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LocalizationHelperServiceProvider::class
        ];
    }
}
