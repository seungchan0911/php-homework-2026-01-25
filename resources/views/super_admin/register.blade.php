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
    <div class="text title">서점 관리자 등록</div>
    <form class="default" action="{{ route('super_admin.register') }}" enctype="multipart/form-data" method="POST">
      @csrf
      <input type="text" name="store" placeholder="서점" value="{{ old('store') }}">
      <input type="text" name="username" placeholder="아이디" value="{{ old('username') }}">
      <input type="password" name="password" placeholder="비밀번호" value="{{ old('password') }}">
      <button class="button default">등록</button>
    </form>
  </main>
  <x-alert />
</body>
</html>