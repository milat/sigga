<?php

namespace App\Utils;

abstract class Friendly
{
    public static function get(string $label = null, string $language = null)
    {
        if (!$label) {
            return 'generic';
        }
        $text = Language::get($label, $language);

        Text::removeAccent($text);
        Text::replaceSpaces($text);

        return strtolower($text);
    }
}
