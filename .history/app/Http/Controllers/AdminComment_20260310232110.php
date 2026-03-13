<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminComment extends Controller
{
    public function index() { return view('admin.comments.index'); }
    public function destroy($id) { return redirect()->back(); }
    public function approve($id) { return redirect()->back(); }
}
