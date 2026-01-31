<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
  <link rel="stylesheet" href="{{ asset('css/store/home.css') }}">
</head>
<body>
  <x-layout.header />
  <main>
    <div class="text title">서점 목록</div>
    <ul class="stores">
      @forelse($stores as $store)
      <li>
        <div class="group">
          <a href="{{ route('stores.show', $store->id) }}" class="text medium">{{ $store->name }}</a>
          <div class="text small">도서 {{ $store->books->count() }}권</div>
        </div>
        @if($store->user)
        <div class="text small">관리자: {{ $store->user->username }}</div>
        @else
        <div class="text small">관리자: 없음</div>
        @endif
      </li>
      @empty
      <div class="text small">아직 서점이 없어요! ㅠㅠ</div>
      @endforelse
    </ul>
  </main>
  <x-alert />
</body>
</html>