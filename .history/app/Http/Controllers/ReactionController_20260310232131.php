<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function store(Request $request, $news)
    {
        return response()->json(['status' => 'ok']);
    }
    public function show($news)
    {
        return response()->json(['reactions' => []]);
    }
}
