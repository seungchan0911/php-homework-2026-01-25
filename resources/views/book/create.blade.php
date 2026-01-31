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
    <div class="text title">도서 등록</div>
    <form class="default" action="{{ route('books.store') }}" enctype="multipart/form-data" method="POST">
      @csrf
      <input type="text" name="name" placeholder="도서 제목">
      <input type="file" name="image">
      <input type="text" name="quantity" placeholder="도서 재고">
      <button class="button default">등록</button>
    </form>
  </main>
  <x-alert />
</body>
</html>