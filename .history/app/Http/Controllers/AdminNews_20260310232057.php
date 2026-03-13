<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminNews extends Controller
{
    public function index() { return view('admin.news.index'); }
    public function create() { return view('admin.news.create'); }
    public function store(Request $r) { return redirect()->back(); }
    public function show($id) { return redirect()->route('admin.news.index'); }
    public function edit($id) { return view('admin.news.edit'); }
    public function update(Request $r, $id) { return redirect()->back(); }
    public function destroy($id) { return redirect()->back(); }
    public function toggleStatus($id) { return redirect()->back(); }
}
