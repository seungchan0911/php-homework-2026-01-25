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
    <div class="text title">서점 등록</div>
    <form class="default" action="{{ route('stores.store') }}" enctype="multipart/form-data" method="POST">
      @csrf
      <input type="text" name="name" placeholder="서점 이름">
      <input type="file" name="logo">
      <button class="button default">등록</button>
    </form>
  </main>
  <x-alert />
</body>
</html>