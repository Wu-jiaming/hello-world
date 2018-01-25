<?php

namespace App\Http\Controllers;



class MemberController extends Controller
{
    public function toLogin($value='')
    {
        return view('login');
    }

    public function toRegister($value='')
    {
        return view('register');
    }
}
