<?php

namespace App\Http\Controllers;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        if (in_array($locale, ['en', 'uk', 'pl'])) {
            session()->put('locale', $locale);
        }
        return back();
    }
}