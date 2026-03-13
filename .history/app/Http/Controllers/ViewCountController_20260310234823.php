<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewCountController extends Controller
{
    public function increment(Request $request, $news)
    {
        return response()->json(['status' => 'ok']);
    }
}
