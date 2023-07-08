@extends('layouts')

@section('content')
    <div class="container">
        <div class="container-body">
            <div class="card">
                <div class="pm0 pd1 contents contents-1">
                    <div class="img-me">
                        <img src="{{url('/img/me.png')}}" alt="me">
                    </div>
                    <div class="name-area">
                        <p class="name">秋本すばこ</p>
                        <p class="name-roman">Subaco Akimoto</p>
                    </div>
                </div>

                <div class="pm0 pd1 contents contents-2">
                    <div class="title">
                        <ul>
                            <li class="main">Songwriter</li>
                            <li class="submain">from <a href="http://monobeat.info">STUDiO MONOBEAT</a></li>
{{--                            <li class="sub">ex: <a href="http://monobeat.info">Maple Blue</a></li>--}}
                        </ul>
                        <ul>
                            <li class="main">Web Developer</li>
                        </ul>
                    </div>

                    <div class="socials">
                        <ul>
                            <li>
                                <a href="https://twitter.com/mcddx330" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/mcddx330" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://mcddx330.hatenadiary.jp" target="_blank">
                                    <i class="far fa-newspaper"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://soundcloud.com/dimbow" target="_blank">
                                    <i class="fab fa-soundcloud"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/channel/UCSoMm43dA2LYm8ExwJQaCBA" target="_blank">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://github.com/mcddx330" target="_blank">
                                    <i class="fab fa-github"></i>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:monobeat.030@gmail.com" target="_blank">
                                    <i class="far fa-envelope"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <hr/>

                <div class="pm0 pd1 contents">
                    <div class="title">
                        <p class="main">Tool / Skills</p>
                    </div>
                    <div class="lists">
                        <ul>
                            <li>
                                Logic Pro
                                <br>
                                (write to publish)
                            </li>
                            <br>
                            <li>
                                Studio One
                                <br>
                                (mix to publish)
                            </li>
                            <br>
                            <li>PhpStorm + Laravel</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
