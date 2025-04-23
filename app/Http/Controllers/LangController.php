<?php

namespace App\Http\Controllers;

class LangController extends Controller
{
    public function lang($lang)
    {
        if (in_array($lang, ['en', 'ro'])) {
            session(['locale' => $lang]);
        }

        return redirect()->back();
    }

}
