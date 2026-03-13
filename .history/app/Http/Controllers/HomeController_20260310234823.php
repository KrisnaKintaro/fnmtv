<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('viewers.home');
    }

    public function trending()
    {
        return view('viewers.home');
    }
}
