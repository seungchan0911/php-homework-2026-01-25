<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/mypage.css') }}">
  <style>
  </style>
</head>
<body>
  <x-alert />
  <x-layout.header />
  
  <main>
    <div class="text title">{{ $user->username }}님의 대여 기록</div>
    
    <div class="user-info">
      <p><strong>아이디:</strong> {{ $user->username }}</p>
      <p><strong>가입일:</strong> {{ $user->created_at->format('Y-m-d') }}</p>
      <p><strong>총 대여 횟수:</strong> {{ $rentals->count() }}회</p>
      <p><strong>현재 대여 중:</strong> {{ $rentals->where('is_returned', 0)->count() }}권</p>
    </div>
    
    <table>
      <thead>
        <tr>
          <th>책</th>
          <th>대여일</th>
          <th>반납 예정일</th>
          <th>상태</th>
          <th>반납일</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rentals as $rental)
        <tr class="{{ $rental->is_returned ? '' : 'active' }}">
          <th>{{ $rental->book->name }}</th>
          <td>{{ $rental->created_at->format('Y-m-d') }}</td>
          <td>{{ $rental->due_date->format('Y-m-d') }}</td>
          <th>
            @if($rental->is_returned)
              반납 완료
            @else
              대여 중
            @endif
          </th>
          <td>
            @if($rental->is_returned)
              {{ $rental->updated_at->format('Y-m-d') }}
            @else
              -
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </main>
</body>
</html>