<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
</head>
<body>
  <x-layout.header />
  <main>
    <div class="text title">회원가입</div>
    <form class="default" action="{{ route('register') }}" method="POST">
      @csrf
      <input type="text" name="username" value="{{ old('username') }}" placeholder="아이디">
      <input type="password" name="password" placeholder="비밀번호">
      <button class="button default">회원가입</button>
    </form>
  </main>
  <x-alert />
</body>
</html>