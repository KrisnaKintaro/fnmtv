<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index() { return view('admin.finance.index'); }
    public function create() { return ""; }
    public function store(Request $r) { return redirect()->back(); }
    public function show($id) { return redirect()->route('admin.finance.index'); }
    public function edit($id) { return ""; }
    public function update(Request $r, $id) { return redirect()->back(); }
    public function destroy($id) { return redirect()->back(); }
    public function togglePayment($id) { return redirect()->back(); }
}
