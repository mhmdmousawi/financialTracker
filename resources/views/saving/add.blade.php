@extends('layouts.headers.saving.add')

<script src="{{ asset('js/saving/verification.js') }}" defer></script>
<script src="{{ asset('js/transaction/adding/category.js') }}" defer></script>

@section('content_add')

@include('saving.inc.verification_modal')
@include('saving.inc.category_modal')

<hr>
<form id="add_saving_form"  class="form-horizontal" action="{{config('app.url')}}/add/saving/confirmed" method="POST">
    @csrf
    <input id="csrf_token" type="hidden" value="{{csrf_token()}}">
    <input id="request_url" type="hidden" value="{{config('app.url')}}/saving/validate">

    <div class="form-group">
        <label class="control-label col-xs-12 col-lg-4 text-primary" for="gaol_amount">Goal Amount:</label>
        <div class="col-xs-9 col-lg-3">
            <input id='goal_amount'type="number" name='goal_amount'  class="form-control{{ $errors->has('goal_amount') ? ' is-invalid' : '' }}" value="{{ old('goal_amount') }}" placeholder="Goal Amount"/>
            @if ($errors->has('goal_amount'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('goal_amount') }}</strong>
                </span>
            @endif
        </div>

        <div class="col-xs-3 col-lg-1">
            <select class="custom-select form-control form-control-lg" style="height:35px"  id="currency_id" name="currency_id" >
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

    <div class="form-group">
        <label class="control-label col-xs-12 col-lg-4 text-primary" for="amount">Amount per Frequency:</label>
        <div class="col-xs-12 col-lg-4">
            <input id='amount' type="number" name='amount' placeholder="Amount" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ old('amount') }}"/>
            @if ($errors->has('amount'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('amount') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group" data-toggle="modal" data-target="#category_choosing_modal">
        <label class="control-label col-lg-4 text-primary" for="category">Category:</label>
        <div id="category_chosen_div">
            <div class="col-xs-8 col-lg-4">
                <p class="col-lg-10" id="category_chosen_id">Click to choose your category  &nbsp;&nbsp;</p>
                <span class="col-xs-4 col-lg-2 glyphicon glyphicon-piggy-bank" style="font-size:30px"></span>
                <input type='hidden' id="category_id" name='category_id' value=""/>
            </div>
        </div>
    </div>

    <hr>

    <div class="form-group">
        <label class="control-label col-xs-12 col-lg-4 text-primary" for="title">Title:</label>
        <div class="col-xs-12 col-lg-4">
            <input id='title' name='title' placeholder="Title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}"/>
            @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-lg-4 text-primary" for="description">Description:</label>
        <div class="col-xs-12 col-lg-4">
            <input id='description' name='description' placeholder="Description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}"/>
            @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-xs-12 col-lg-4 text-primary" for="start_date">Start Date:</label>
        <div class="col-xs-12 col-lg-4">
            <input type='date' id='start_date' name='start_date' class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" value="{{ old('start_date') }}" required/>
        </div>
        @if ($errors->has('start_date'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('start_date') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-lg-4 text-primary" for="repeat">Saving Frequency:</label>
        <div class="col-xs-12 col-lg-4">
            <select class="custom-select form-control" style="height: 35px" id="repeat_id" name="repeat_id" >
                @foreach($repeats as $repeat)
                    @if($repeat->type == "weekly" || $repeat->type == "monthly")
                        <option value="{{ $repeat->id }}" >{{$repeat->type}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    
    <hr>

    <div class="form-group">      
        <div class="col-xs-4 col-xs-offset-4 col-lg-4 col-lg-offset-5" >
            <input id="verify_bnt" type="button" class="btn btn-default"  value="Verify"/>
        </div>
    </div>

    <input id="show_verification_modal" type="hidden" data-toggle="modal" data-target="#saving_varification_modal" value="Verify"/>
    <button id="submit_btn" name= "submit_btn" type="hidden" style="display:none;"></button>
</form>


@endsection