@extends('layouts.headers.dashboard')
<script src="{{ asset('js/charts_overview.js') }}" defer></script>


@section('content_dashboard')
    <hr class="col-xs-12 col-lg-12">   
    <h2 class="text-center">Overview</h2>
    <hr class="col-xs-12 col-lg-12">
    <form class="form-virtical ">
        <div class="form-group text-center">
            <label class="control-label col-xs-12 text-info text-lg" for="">Total</label>
        </div>
        <div class="form-group text-center">
            <p class="col-xs-12 text-secondary" for="">{{round($user->balance,2)}} {{$user->profile->defaultCurrency->code}}</p>
        </div>  
    </form>
    
    <form class="form-virtical ">
        <div class="form-group text-center">
            <label class="control-label col-xs-4 text-info" for="">Money In</label>
            <label class="control-label col-xs-4 text-info" for="">Money Out</label>
            <label class="control-label col-xs-4 text-info" for="">Savings</label>
        </div>
        
        <div class="form-group text-center">
            <p class="col-xs-4 text-secondary" for="">{{round($user->money_in,2)}} {{$user->profile->defaultCurrency->code}}</p>
            <p class="col-xs-4 text-secondary" for=""> -{{round($user->money_out,2)}} {{$user->profile->defaultCurrency->code}}</p>
            <p class="col-xs-4 text-secondary" for="">{{round($user->saving,2)}} {{$user->profile->defaultCurrency->code}}</p>
        </div>  
    </form>
    <hr class="col-xs-12 col-lg-12">
    
    @include('dashboard.overview_parts.income')
    @include('dashboard.overview_parts.expense')
    @include('dashboard.overview_parts.saving')

@endsection
