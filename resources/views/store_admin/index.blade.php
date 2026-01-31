<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
  <link rel="stylesheet" href="{{ asset('css/store/view.css') }}">
</head>
<body>
  <x-layout.header />
  <main>
    <div class="text title">{{ $store->name }}</div>
    <div class="bookcase">
      @forelse($store->books as $book)
      <div class="book">
        @if ($book->image)<img src="{{ asset('storage/' . $book->image) }}" alt="">@endif
        <div class="group">
          <div class="name">{{ $book->name }}</div>
          <div class="price text small">재고: {{ $book->quantity }}권</div>
          <a href="{{ route('books.edit', $book->id) }}" class="button default small">수정하기</a>
        </div>
      </div>
      @empty
      <div class="text small">아직 책이 없어요! ㅠㅠ</div>
      @endforelse
    </div>
  </main>
  <x-alert />
</body>
</html>