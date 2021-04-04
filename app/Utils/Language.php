<?php

namespace App\Utils;

abstract class Language
{
    public static function get(string $label, string $language = null)
    {
        $language = $language ?: config('language.default');

        return config("language.{$language}.{$label}");
    }

    public static function all(string $language = null)
    {
        $language = $language ?: config('language.default');
        return config("language.{$language}");

    }
}
