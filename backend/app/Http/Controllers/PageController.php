<?php

namespace App\Http\Controllers;

class PageController extends Controller
{

    public function vueAuth()
    {
        return view('pages.vueAuth');
    }

    public function passport()
    {
        return view('pages.passport');
    }

    function private () {
        return view('pages.private');
    }
}
