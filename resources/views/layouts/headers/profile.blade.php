
@extends('layouts.headers.main')


@section('content')

<nav class="navbar navbar-expand-md app_color_default navbar-laravel">
    <div class="container">
        <a class="navbar-brand text-light text-uppercase" href="{{config('app.url')}}/profile">Profile Configuration</a>
        <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                
            </ul>
            
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light"  data-toggle="modal" data-target="#edit_profile_modal">Edit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    <li>
                        <a class="nav-link text-light" href="{{config('app.url')}}/dashboard/overview">Back</a>
                    </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="edit_profile_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Username: {{ $user->profile->username }}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form class="form-horizontal" action="{{config('app.url')}}/profile/edit" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>For Now! You can only change your base currency: </p>
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-xs-6" for="currency"> Set your base currency to:</label>
                            <div class="col-xs-3">
                                <select name="currency_select" id="currency_select" class="custom-select form-control form-control-lg" style="height:35px" >
                                    @foreach($currencies as $currency)
                                        @if($currency->id == $user->profile->defaultCurrency->id )
                                            <option value="{{ $currency->id }}" selected>{{$currency->code}}</option>
                                        @else
                                            <option value="{{ $currency->id }}" >{{$currency->code}}</option>
                                        @endif
                                        
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<div class="container">
    @yield('content_profile')
</div>

@endsection