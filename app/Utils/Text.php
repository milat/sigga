<?php

namespace App\Utils;

abstract class Text
{
    public static function removeAccent(string &$text)
    {
        $text = str_replace(self::getAccents(), self::getAccentless(), $text);
    }

    public static function replaceSpaces(string &$text, string $replaceWith = '_')
    {
        $text = str_replace(' ', $replaceWith, $text);
    }

    public static function getClassName($class, $strtolower = true)
    {
        $array = explode('\\', get_class($class));
        $classname = end($array);
        return ($strtolower) ? strtolower($classname) : $classname;
    }

    private static function getAccents()
    {
        return ['à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú'];
    }

    private static function getAccentless()
    {
        return ['a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', '0', 'U', 'U', 'U'];
    }
}
