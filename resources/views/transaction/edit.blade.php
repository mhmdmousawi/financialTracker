@extends('layouts.headers.transaction.edit')

<script src="{{ asset('js/transaction/adding/type.js') }}" defer></script>
<script src="{{ asset('js/transaction/adding/category.js') }}" defer></script>
<script src="{{ asset('js/transaction/adding/repeat.js') }}" defer></script>

@section('content_edit')

@include('transaction.inc.delete_modal')

<div class="row" >
    <div class="btn-group col-xs-10 col-xs-offset-1 col-lg-4 col-lg-offset-4 " role="group" aria-label="...">
        <button type="button"  class="btn btn-default col-xs-6 col-lg-6 {{ $transaction->type == "income" ? ' active' : '' }} " >Income</button>
        <button type="button"  class="btn btn-default col-xs-6 col-lg-6 {{ $transaction->type == "expense" ? ' active' : '' }}">Expense</button>
    </div>
</div>

<form class="form-horizontal" action="{{config('app.url')}}/edit/transaction" method="POST">
    @csrf
    
    
    <input type = "hidden" name='id' value = "{{$transaction->id}}"/>
    {{-- <input type="hidden" id="type_input" name="type" value="{{$transaction->type}}"/> --}}
    
    <hr>
    
    <div class="form-group">
        <label class="control-label col-xs-12 col-lg-4  text-primary" for="amount">Amount:</label>
        <div class="col-xs-8 col-lg-3">
            <input type="number" name='amount' placeholder="0.00" class=" form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{$transaction->amount}}"required/>
        </div>
        <div class="col-xs-4 col-lg-1">
            <select class="custom-select form-control form-control-lg" style="height:35px"  name="currency_id" >
                @foreach($currencies as $currency)
                    @if($currency->id == $transaction->currency_id)
                        <option value="{{ $currency->id }}" selected>{{$currency->code}}</option>
                    @else
                        <option value="{{ $currency->id }}" >{{$currency->code}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
     {{-- data-toggle="modal" data-target="#category_choosing_modal"> --}}
        <label class="control-label col-lg-4 text-primary" for="category">Category:</label>
        <div id="category_chosen_div">
            <div class="col-lg-4">
                <p class="col-xs-8 col-lg-10" id="category_chosen_id">{{$transaction->category->title}} &nbsp;&nbsp;</p>
                <span class="col-xs-4 col-lg-2 {{$transaction->category->logo->class_name}}" style="font-size:30px"></span>
                <input type='hidden' name='category_id' value="{{$transaction->category->id}} "/>
            </div>
        </div>
    </div>
        
    <hr>
    <div class="form-group">
    <label class="control-label col-lg-4 text-primary" for="title">Title:</label>
        <div class="col-lg-4">
            <input type='text' name='title' placeholder="Title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{$transaction->title}}" required/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-4 text-primary" for="description">Description:</label>
        <div class="col-lg-4">
            <textarea rows="2" name='description' placeholder="Description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">
                {{$transaction->description}}
            </textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-lg-4 text-primary" for="start_date">Start Date:</label>
        <div class="col-lg-4">
            <input type='date' name='start_date' class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" value="{{$transaction->start_date}}" readonly/>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="control-label col-lg-4 text-primary" for="repeat">Repeat:</label>
        <div class="col-lg-4">
            <input id="repeat_select" name="repeat_type" class="form-control" value="{{$transaction->repeat->type}}" readonly/>
            <input type="hidden" id="repeat_select" name="repeat_id" class="form-control" value="{{$transaction->repeat->id}}"/>
        </div>
    </div>
    @if($transaction->repeat->type !='fixed')
        <div id="end_date_div" class="form-group" >
            <label class="control-label col-lg-4 text-primary" for="end_date">End Date:</label>
            <div class="col-lg-4">
                <input type='date' name='end_date' class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" value="{{$transaction->end_date}}" readonly/><br>
            </div>
        </div>
        
        @if($transaction->repeat->type !='fixed')
            <div class="form-group edit_info">
                <div class="col-xs-10 col-xs-offset-1 col-lg-4 col-lg-offset-4 custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="defaultUnchecked" value="future" name="edit_type" checked>
                    <label class="custom-control-label" for="defaultUnchecked">All future transactions</label>
                </div>
                
                <div class="col-xs-10 col-xs-offset-1 col-lg-4 col-lg-offset-4  custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="defaultChecked" value="all" name="edit_type" >
                    <label class="custom-control-label" for="defaultChecked">All transaction</label>
                </div>
            </div>
        @endif
    @else
        <div class="edit_info">
            <input type="hidden" name="edit_type" value="all" checked>
        </div>
    @endif

    
    <hr>
    <div class="form-group">       
        <div class="col-xs-4 col-xs-offset-2 col-lg-1 col-lg-offset-4" >
            <input class="btn btn-default" type="submit" value="Update">
        </div>
        <div class="col-xs-4 col-lg-1 " >
            <input class="btn btn-default" type="button" value="Delete" data-toggle="modal" data-target="#delete_modal">
        </div>
    </div>
  

</form>

<hr>
<p class="text-center text-info">You are only allowed to edit only the amount, currency, title, or the descrption</p>


@endsection