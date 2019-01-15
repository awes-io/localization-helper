<?php

namespace AwesIO\LocalizationHelper\Contracts;

interface LocalizationHelper
{
    /**
     * Translate the given message
     *
     * @param $key
     * @param null $default
     * @param array $placeholders
     * @return mixed
     */
    public function trans($key, $default = null, $placeholders = []);
}
