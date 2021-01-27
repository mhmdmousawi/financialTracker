@extends('layouts.headers.dashboard')
<script src="{{ asset('js/charts.js') }}" defer></script>

@section('content_dashboard')

<hr>
<h2 class="text-center">Savings</h2>

<form class="form-virtical ">
    <div class="form-group text-center">
        <label class="control-label col-xs-4 text-info" for="">Num of Savings</label>
        <label class="control-label col-xs-4 text-info" for="">Total Amount</label>
        <label class="control-label col-xs-4 text-info" for="">Daily Average</label>
    </div>
    
    <div class="form-group text-center">
        <p class="col-xs-4 text-secondary" for="">{{count($user->expanded_transactions)}}</p>
        <p class="col-xs-4 text-secondary" for="">{{$user->profile->defaultCurrency->code}} {{round($user->total_amount,2)}}</p>
        <p class="col-xs-4 text-secondary" for="">{{$user->profile->defaultCurrency->code}} {{round($user->daily_average,2)}}</p>
    </div>  
</form>
<br><br><br><hr>

<div class="statistics_div_big col-sm-12 col-lg-8 col-lg-offset-2">
    <div class="btn-group titles titles-dashboard" role="group" aria-label="...">
        <input class="btn btn-default" type='button' name="pie" id="chart_pie" value="Pie"/>
        <input class="btn btn-default" type='button' name="bar" id="chart_bar" value="Bar"/>
    </div>
    <div id="chart_div">
        <canvas id="chart_canvas"></canvas>
    </div>
    <p type="hidden" id="no_data" value="No Data to Display">No Data to Display</p>
    <input type="hidden" id="stat_lables" value="{{ implode(',', $user->stat_categories_info[0] )}}"/>
    <input type="hidden" id="stat_data" value="{{ implode(',', $user->stat_categories_info[1] )}}"/>
</div>

<div class="transactions col-sm-12 col-lg-8 col-lg-offset-2">
    <p class="col-sm-12 col-lg-5 text-info">Transactions:</p>
    @foreach(($user->expanded_transactions) as $saving)
    <div class="col-sm-12 col-lg-12 transaction_card_big">
            <div class="card-counter primary">
                <span class="col-xs-8 col-lg-6 text-light" style="padding:2px"><b>Title:</b> {{$saving->title}}</span>
                <span class="col-xs-4 col-lg-6 text-right text-light" style="padding:2px">{{$saving->currency->code}} <strong>{{$saving->amount}}</strong></span>
                <span class="col-xs-8 col-lg-6 text-light" style="padding:2px"><b>Categ:</b> {{$saving->category->title}}</span>                        
                <span class="col-xs-4 col-lg-6 text-right text-light" style="padding:2px"> % {{round($saving->percentage,0)}}</span>
                <span class="col-xs-7 col-lg-6 text-light" style="padding:2px"><b>Date:</b> {{$saving->start_date}}</span>
                <span class="col-xs-5 col-lg-6 text-right logo-big {{$saving->category->logo->class_name}}" style="padding:2px"></span>
            </div>
        </div>
    @endforeach
</div>


@endsection
