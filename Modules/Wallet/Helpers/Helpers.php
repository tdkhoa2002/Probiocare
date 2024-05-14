<?php

use Hashids\Hashids;

if (!function_exists('encodeString')) {
    function encodeString($string, $length = 30)
    {
        $hashids = new Hashids(config('slat.slat_encode'), $length);
        return $hashids->encodeHex(strToHex($string));
    }
}
if (!function_exists('decodeString')) {
    function decodeString($string)
    {
        $hashids = new Hashids(config('slat.slat_encode'));
        $decode = $hashids->decodeHex($string);
        return hexToStr($decode);
    }
}

if (!function_exists('strToHex')) {
    function strToHex($string)
    {
        return bin2hex($string);
    }
}

if (!function_exists('hexToStr')) {
    function hexToStr($hex)
    {
        return hex2bin($hex);
    }
}
