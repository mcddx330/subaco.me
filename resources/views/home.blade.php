@extends('layouts')

@section('content')
<div class="container">
  <div class="container-body">
    <div class="contents-area">
      <div class="pm0 contents contents-1">
        <div class="img-me">
          <img src="{{url('/img/me.png')}}" alt="me">
        </div>
        <div class="name-area">
          <p class="name">秋本すばこ</p>
          <p class="name-roman">Subaco Akimoto</p>
        </div>
      </div>

      <div class="pm0 contents contents-2">
        <div class="skills">
          <ul class="mb1em">
            <li class="title">PHP Developer</li>
            <ul class="lists">
              <li>IDE: PhpStorm</li>
              <li>FW: Laravel</li>
              <li>DB: MySQL / MariaDB</li>
            </ul>
          </ul>
          <ul>
            <li class="title">Songwriter</li>
            <li class="subtitle">( as <a href="http://monobeat.info">STUDiO MONOBEAT</a> )</li>
            <ul class="lists">
              <li>Write: Logic Pro</li>
              <li>Edit: Studio One</li>
              <li>Fix: Adobe Audition / iZotope RX</li>
            </ul>
          </ul>
        </div>

        <div class="socials">
          <ul>
            <li><a href="https://twitter.com/mcddx330" target="_blank"><i class="fab fa-twitter"></i></a></li>
            <li><a href="https://github.com/mcddx330" target="_blank"><i class="fab fa-github"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection