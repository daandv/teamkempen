<?php
/**
 * Created by PhpStorm.
 * User: sydre
 * Date: 03/02/2019
 * Time: 19:55
 */

function udesly_string_strip_subdirectory_dots($string) {
    return str_replace('../', '', $string);
}

function udesly_string_is_absolute($string) {
    return udesly_string_starts_with($string, 'http');
}

function udesly_string_starts_with($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}
