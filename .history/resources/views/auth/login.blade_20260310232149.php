@extends('layouts.master')

@section('title','Admin Login')

@section('content')
<div class="container" style="max-width:400px;margin:60px auto;">
    <h2>Login Admin</h2>
    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="field">
            <label>Email</label>
            <input type="text" name="email" />
        </div>
        <div class="field">
            <label>Password</label>
            <input type="password" name="password" />
        </div>
        <button type="submit" class="btn btn-red">Login</button>
    </form>
</div>
@endsection