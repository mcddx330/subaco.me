@extends('layouts')

@section('header')
  <header>
    <div class="links">
      <div class="links-body">
        <ul>
          <li><a href="{{route('index')}}">subaco.me</a></li>
          <li><a href="{{route('diary.index')}}">diary</a></li>
        </ul>
      </div>
    </div>
  </header>
@endsection
