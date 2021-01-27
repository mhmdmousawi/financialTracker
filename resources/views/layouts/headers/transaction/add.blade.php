@extends('layouts.headers.main')

@section('content')

<nav class="navbar navbar-expand-md app_color_default navbar-laravel">
    <div class="container">
        <a class="navbar-brand text-light text-uppercase" href="#">Adding Transaction</a>
        <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                
            </ul>
            
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li>
                    <a class="nav-link text-light" href="{{config('app.url')}}/dashboard/overview">Cancel</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    @yield('content_add')
</div>

@endsection