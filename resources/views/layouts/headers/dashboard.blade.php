
        
@extends('layouts.headers.main')

@section('content')

<nav class="navbar navbar-expand-md app_color_default navbar-laravel">
    <div class="container">
        <a class="navbar-brand text-light text-uppercase" href="{{config('app.url')}}/dashboard">Dashboard</a>
        <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
            
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-light " href="{{config('app.url')}}/profile">Profile</a>
                    </li>
                    <li>
                        <a class="nav-link text-light "  href="#" data-toggle="modal" data-target="#time_filter_modal">Calender</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-light " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Add
                        </a>
    
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{config('app.url')}}/add/category">Category</a>
                            <a class="dropdown-item" href="{{config('app.url')}}/add/transaction">Transaction</a>
                            <a class="dropdown-item" href="{{config('app.url')}}/add/saving">Saving Plan</a>
                            <a class="dropdown-item" href="{{config('app.url')}}/add/saving/smart">Smart Plan</a>
    
                        </div>
                    </li>
                    
                @endguest
            </ul>
        </div>
    </div>
    
</nav>



<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="time_filter_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Dashboard Filter:</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form class="form-horizontal" action="{{config('app.url')}}/dashboard/change/filter" method="POST">
                    @csrf

                    <div class="modal-body">
                        <p>Choose the date you would like to represent your data in, and the type of presentation: </p>

                        <div class="form-group">
                            <div class="col-xs-3">
                                <select name="type_filter"  class="custom-select form-control form-control-lg" style="height:35px" >
                                    @if(Session::get('time_filter')['type_filter'] == "weekly")
                                        <option value="weekly" selected>Weekly</option>
                                        <option value="monthly" >Monthly</option>
                                        <option value="yearly" >Yearly</option>
                                    @elseif(Session::get('time_filter')['type_filter'] == "monthly")
                                        <option value="weekly" >Weekly</option>
                                        <option value="monthly" selected>Monthly</option>
                                        <option value="yearly" >Yearly</option>
                                    @elseif(Session::get('time_filter')['type_filter'] == "yearly")
                                        <option value="weekly" >Weekly</option>
                                        <option value="monthly" >Monthly</option>
                                        <option value="yearly" selected>Yearly</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <input type="date" class=" form-control" name="date_filter" value="{{Session::get('time_filter')['date_filter']}}"/>                        
                            </div>
                        </div>
                        <input type="hidden" name="dashboard_type" value="{{ $dashboard_type }}"/>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">Ok</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row" >
        <div class="btn-group titles titles-dashboard" role="group" aria-label="...">
            <a href="{{config('app.url')}}/dashboard/overview" >
                <button type="button" id="title_income" class="btn btn-default  {{ $dashboard_type == "overview" ? ' active' : '' }}" >Overview</button>
            </a>
            <a href="{{config('app.url')}}/dashboard/incomes" >
                <button type="button" id="title_expense" class="btn btn-default {{ $dashboard_type == "income" ? ' active' : '' }}">Incomes</button>
            </a>
            <a href="{{config('app.url')}}/dashboard/expenses" >
                <button type="button" id="title_expense" class="btn btn-default {{ $dashboard_type == "expense" ? ' active' : '' }}">Expenses</button>
            </a>
            <a href="{{config('app.url')}}/dashboard/savings" >
                <button type="button" id="title_expense" class="btn btn-default {{ $dashboard_type == "saving" ? ' active' : '' }}">Savings</button>
            </a>
        </div>
    </div>

    <hr>
    <div class="text-center text-info ">
        <p>This is a {{Session::get('time_filter')['type_filter']}} representation</p>
    </div>
    
    @yield('content_dashboard')

</div>
@endsection

