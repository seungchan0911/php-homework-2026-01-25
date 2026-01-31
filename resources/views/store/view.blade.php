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
    @if($store->logo)
    <div class="store-logo"><img src="{{ asset('storage/' . $store->logo) }}" alt=""></div>
    @endif
    <div class="text title">{{ $store->name }} @if(auth()->user()->role == 2) <a class="button small" href="{{ route('stores.edit', $store) }}">수정</a> @endif</div>
    <div class="bookcase">
      @forelse($store->books as $book)
      <div class="book {{ auth()->user()->role == 2 ? 'super-admin' : ''}}">
        @if($book->image)<img src="{{ asset('storage/' . $book->image) }}" alt="">@endif
        <div class="group">
          <div class="name">{{ $book->name }}</div>
          @php
            $hasRented = auth()->user()->rentals()
              ->where('book_id', $book->id)
              ->where('is_returned', 0)
              ->exists();
          @endphp
          @if($hasRented)
            <div class="price text small">{{ $book->quantity }}권 대여 가능</div>
            <button class="button small disabled">대여중</button>
          @elseif(auth()->user()->role == 2)
            <div class="price text small">재고: {{ $book->quantity }}</div>
          @elseif($book->quantity > 0)
            <div class="price text small">{{ $book->quantity }}권 대여 가능</div>
            <form action="{{ route('rent', $book) }}" method="POST">
              @csrf
              <button class="button small">대여하기</button>
            </form>
          @else
            <div class="price text small">재고 없음</div>
            <button class="button small disabled">대여불가</button>
          @endif
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