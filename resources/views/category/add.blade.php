@extends('layouts.headers.category.add')

@section('content_add')
<script src="{{ asset('js/category/adding/logo.js') }}" defer></script>

@include('category.inc.logo_modal')
<hr>
   
<form id="add_saving_form"  class="form-horizontal" action="{{config('app.url')}}/add/category" method="POST">
    @csrf
    <div class="form-group">
        <label class="control-label col-xs-12 col-lg-4 text-primary" for="type">Type:</label>
        <div class="col-xs-12 col-lg-4">
            <select class="custom-select form-control form-control-lg" style="height:35px" name="type" >
                <option value="income" selected>Income</option>
                <option value="expense" >Expense</option>
                <option value="saving" >Saving</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-lg-4 text-primary" for="title">Title:</label>
        <div class="col-lg-12 col-lg-4">
            <input id='title' name='title' placeholder="Title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}"/>
            @if ($errors->has('title'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group" data-toggle="modal" data-target="#logo_choosing_modal">
        <label class="control-label col-xs-12 col-lg-4 text-primary" for="category">Logo:</label>
        <div class="col-xs-8  col-lg-3">
            <p class="col-lg-12 text-info" id="logo_chosen_id">Click to choose your logo  &nbsp;&nbsp;</p>
        </div>
        <div id="logo_chosen_div" class="col-xs-4 col-lg-5">
            <span class="col-xs-4 col-lg-2 glyphicon glyphicon-piggy-bank" style="font-size:30px"></span>
            <input type='hidden' id="logo_id" name='logo_id' value=""/>
        </div>
    </div>
    <hr>
    <div class="form-group">       
        <div class="col-xs-5 col-xs-offset-5 col-lg-4 col-lg-offset-4" >
            <input type="submit" class="btn btn-default"  value="Add"/>
        </div>
    </div>
</form>

@endsection