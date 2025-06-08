<?php

if (!function_exists('old_value')) {
    function old_value($name, $default = '')
    {
        return old($name) ?? $default;
    }
}

if (!function_exists('select_option')) {
    function select_option($value, $compare)
    {
        return $value == $compare ? 'selected' : '';
    }
}
