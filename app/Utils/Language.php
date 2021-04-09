<?php

namespace App\Utils;

use App\Models\Request;
use Illuminate\Support\Facades\Auth;

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

    public static function feedbackSent(Request $request, string $language = null)
    {
        $language = $language ?: config('language.default');

        if (!$request->document) {
            return '';
        }

        $text = config("language.{$language}.feedback_sent");
        $text = str_replace("<capslock_office_name>", strtoupper(Auth::user()->office->name), $text);
        $text = str_replace("<request_title>", $request->title, $text);
        $text = str_replace("<office_name>", Auth::user()->office->name, $text);
        $text = str_replace("<document_date>", date('d/m/Y', strtotime($request->document->date)), $text);
        $text = str_replace("<document_type_name>", $request->document->type->name, $text);
        $text = str_replace("<document_code>", $request->document->code, $text);
        $text = str_replace("<request_title>", $request->title, $text);
        $text = str_replace("<break>", config('system.whatsapp_breakline'), $text);

        return $text;
    }
}
