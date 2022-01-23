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
          <ul>
            <li class="title">PHP Web Developer</li>
            <ul class="lists">
              <li>Laravel</li>
              <li>MariaDB</li>
              <li>PhpStorm</li>
            </ul>
          </ul>
          <ul>
            <li class="title">Songwriter</li>
            <li class="subtitle">(<a href="http://monobeat.info">STUDiO MONOBEAT</a>)</li>
            <ul class="lists">
              <li>Logic Pro</li>
              <li>Studio One</li>
              <li>iZotope RX</li>
            </ul>
          </ul>
        </div>

        <div class="socials">
          <ul>
            <li><a href="https://twitter.com/mcddx330" target="_blank"><i class="fab fa-twitter"></i></a></li>
            <li><a href="https://www.instagram.com/mcddx330" target="_blank"><i class="fab fa-instagram"></i></a></li>
            <li><a href="https://mcddx330.hatenadiary.jp" target="_blank"><i class="far fa-newspaper"></i></a></li>
            <li><a href="https://soundcloud.com/dimbow" target="_blank"><i class="fab fa-soundcloud"></i></a></li>
            <li><a href="https://github.com/mcddx330" target="_blank"><i class="fab fa-github"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection