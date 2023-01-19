@extends('layouts.master')

@section('title', 'Page Title')
 
@section('content') 
<link rel="stylesheet" type="text/css" href="{{ asset('css/indexstyle.css') }}" >

<div class="card m-2">
    <div class="card-header">
      Movies
    </div>
    <div class="card-body">
        <div class = "row">
          <div class="first-movie-img col-sm">
            <img src="{{ $randMovie1 }}" alt="Smiley face"width="100" height="100" style="vertical-align:middle;margin:0px 50px">
          </div>
          <div class="second-movie-img col-sm m">
            <img src="{{ $randMovie }}" alt="Smiley face" width="100" height="100" style="vertical-align:middle;margin:0px 50px">
          </div>
          <div class="three-movie-img col-sm">
            <img src="{{ $randMovie2 }}" alt="Smiley face" width="100" height="100" style="vertical-align:middle;margin:0px 50px">
          </div>
        </div>
      </div>
  </div>
@stop