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
    <div class="text title">서점 수정</div>
    <form class="default" action="{{ route('stores.update', $store) }}" enctype="multipart/form-data" method="POST">
      @csrf
      @method('PUT')
      <input type="text" name="name" placeholder="서점 이름" value="{{ $store->name }}">
      <input type="file" name="logo">
      <button class="button default">수정</button>
    </form>
    <div class="button-group">
      <form action="{{ route('stores.destroy', $store) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="button default">삭제</button>
      </form>
      <a href="/" class="button default">취소</a>
    </div>
  </main>
  <x-alert />
</body>
</html>