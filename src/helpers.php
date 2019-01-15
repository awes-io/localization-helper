<?php

if (!function_exists('_p')) {
    /**
     * Translate the given message
     *
     * @param $key
     * @param $default
     * @param $placeholders
     * @return array|null|string
     */
    function _p($key, $default = null, $placeholders = [])
    {
        return LocalizationHelper::trans($key, $default, $placeholders);
    }
}
