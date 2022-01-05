@extends('diary.layout')

@section('content')

  <div class="contents">

    <div class="sidebar">
      <div class="sidebar-contents">
        DIARY
        <br>
        ここは固定左ペイン30%くらい
        <br>
        記事は70%右上下スクロール
      </div>
    </div>

    <div class="diary">
      <div class="article">
        <h5>{{$article->created_at}}</h5>
        <h1 class="title">
          <a
              href="{{route(
                'diary.show_article', [
                  'ymd' => sprintf('%d%d%d', $article->year, $article->month, $article->day),
                  'slug' => $article->slug
                ]
             )}}"
          >{{$article->title}}</a>
        </h1>
        {!! $article->body !!}
      </div>
    </div>

  </div>

@endsection
