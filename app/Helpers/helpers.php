<?php

if (! function_exists('array_last')) {
    function array_last($array)
    {
        if (!is_array($array) || empty($array)) {
            return null;
        }
        return $array[array_key_last($array)];
    }
}
