<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/mypage.css') }}">
</head>
<body>
  <x-layout.header />
  <main>
    <div class="text title">대여 기록</div>
    <table>
      <thead>
        <tr>
          <th>서점</th>
          <th>책</th>
          <th>대여기간</th>
          <th>반납</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rentals as $rental)
          <tr>
            <td><a href="{{ route('stores.show', $rental->store->id) }}">{{ $rental->store->name }}</a></td>
            <th>{{ $rental->book->name }}</th>
            <td>{{ $rental->status_text }}</td>
            <td>
              @if($rental->is_returned)
              <button class="button small disabled">반납완료</button>
              @else
              <form action="{{ route('return', $rental) }}" method="POST">
                @csrf
                <button class="button small">반납하기</button>
              </form>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </main>
  <x-alert />
</body>
</html>