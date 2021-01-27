@extends('layouts.headers.transaction.add')

<script src="{{ asset('js/transaction/adding/type.js') }}" defer></script>
<script src="{{ asset('js/transaction/adding/category.js') }}" defer></script>
<script src="{{ asset('js/transaction/adding/repeat.js') }}" defer></script>

@section('content_add')

@include('transaction.inc.category_modal')

<div class="row" >
    <div class="btn-group col-xs-10 col-xs-offset-1 col-lg-4 col-lg-offset-4 " role="group" aria-label="...">
        <button type="button" id="title_income" class="btn btn-default col-xs-6 col-lg-6 active" >Income</button>
        <button type="button" id="title_expense" class="btn btn-default col-xs-6 col-lg-6 ">Expense</button>
    </div>
</div>

<form class="form-horizontal" action="{{config('app.url')}}/add/transaction/create" method="POST">
    @csrf
    
    <input type="hidden" id="type_input" name="type" value="income"/>
    

    <hr>
    
    <div class="form-group">
        <label class="control-label col-xs-12 col-lg-4 text-primary" for="amount">Amount:</label>
        <div class="col-xs-8 col-lg-3">
            <input type="number" name='amount' placeholder="0.00" class=" form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ old('amount') }}"required/>
        </div>
        @if ($errors->has('amount'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('amount') }}</strong>
            </span>
        @endif

        <div class="col-xs-4 col-lg-1">
            <select class="custom-select form-control form-control-lg" style="height:35px"  name="currency_id" >
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
    <div class="form-group" data-toggle="modal" data-target="#category_choosing_modal">
        <label class="control-label col-lg-4 text-primary" for="category">Category:</label>
        <div id="category_chosen_div">
            <div class="col-lg-4">
                <p class="col-xs-8 col-lg-10" id="category_chosen_id">Click to choose your category  &nbsp;&nbsp;</p>
                <span class="col-xs-4 col-lg-2 glyphicon glyphicon-piggy-bank" style="font-size:30px"></span>
                <input type='hidden' name='category_id' value=""/>
            </div>
        </div>
        @if ($errors->has('category_id'))
            <span class="invalid-feedback" role="alert">
                <strong>Please choose a category</strong>
            </span>
        @endif
    </div>
        
    <hr>
    <div class="form-group">
    <label class="control-label col-lg-4 text-primary" for="title">Title:</label>
        <div class="col-lg-4">
            <input type='text' name='title' placeholder="Title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}" required/>
        </div>
        @if ($errors->has('title'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <label class="control-label col-lg-4 text-primary" for="description">Description:</label>
        <div class="col-lg-4">
            <textarea rows="2" name='description' placeholder="Description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}">
            </textarea>
            @if ($errors->has('description'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-lg-4 text-primary" for="start_date">Start Date:</label>
        <div class="col-lg-4">
            <input type='date' name='start_date' class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" value="{{ old('start_date') }}" required/>
        </div>
        @if ($errors->has('start_date'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('start_date') }}</strong>
            </span>
        @endif
    </div>
    <hr>
    <div class="form-group">
        <label class="control-label col-lg-4 text-primary" for="repeat">Repeat:</label>
        <div class="col-lg-4">
            <select class="custom-select form-control" style="height: 35px" id="repeat_select" name="repeat_id" >
                @foreach($repeats as $repeat)
                    @if($repeat->type == "fixed")
                        <option value="{{ $repeat->id }}" >Off</option>
                    @else
                        <option value="{{ $repeat->id }}" >{{$repeat->type}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div id="end_date_div" class="form-group" style='display:none'>
        <label class="control-label col-lg-4 text-primary" for="end_date">End Date:</label>
        <div class="col-lg-4">
            <input type='date' name='end_date' class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" value="{{ old('end_date') }}"/><br>
        </div>
        @if ($errors->has('end_date'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('end_date') }}</strong>
            </span>
        @endif
    </div>
    
   <hr>
    <div class="form-group">      
        <div class="col-xs-5 col-xs-offset-5 col-lg-5 col-lg-offset-5" >
            <input class="btn btn-default" type="submit" value="Add">
        </div>
    </div>
</form>


@endsection