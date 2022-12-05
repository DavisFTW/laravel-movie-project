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
            1
          </div>
          <div class="second-movie-img col-sm m">
            2
          </div>
          <div class="three-movie-img col-sm">
            3
          </div>
        </div>
      </div>
  </div>

<div class="card m-2">
  <div class="card-header">Movies</div>
  <div class="card-body">
    <div class = "row">
      <div class="first-movie-img col-sm">
        1
      </div>
      <div class="second-movie-img col-sm m">
        2
      </div>
      <div class="three-movie-img col-sm">
        3
      </div>
    </div>
  </div>
</div>
@stop