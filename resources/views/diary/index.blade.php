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

        <ul class="categories">
          @foreach ($calendars as $calendar)
            <li>{{$calendar->date}} ({{$calendar->count}})</li>
          @endforeach
        </ul>
      </div>
    </div>

    <div class="diary">
      @foreach($articles as $article)
        <div class="list">
          <h5>{{$article->created_at}}</h5>
          <h3>
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
          </h3>
        </div>
      @endforeach
    </div>

  </div>

@endsection
