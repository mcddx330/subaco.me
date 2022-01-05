<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
  >
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{$title}}</title>
  <link rel="stylesheet" href="http://mplus-webfonts.sourceforge.jp/mplus_webfonts.css">
  <link rel="stylesheet" href="@asset('css/style.css')">
  <script src="@assert('js/app.js')"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.2/js/all.js"></script>
</head>
<body id="view-{{ $body_id }}">
@yield('header')
@yield('content')
</body>
</html>