<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        return response()->json(['status' => 'ok']);
    }

    public function index($news)
    {
        return response()->json(['comments' => []]);
    }
}
