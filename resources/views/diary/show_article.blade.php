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
        <h2 class="title">
          <a
              href="{{route(
                'diary.show_article', [
                  'year' => $article->year,
                  'month' => $article->month,
                  'day' => $article->day,
                  'slug' => $article->slug
                ]
             )}}"
          >{{$article->title}}</a>
        </h2>
        {!! $article->body !!}
      </div>
    </div>

  </div>

@endsection
