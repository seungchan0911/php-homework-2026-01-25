<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
  <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
</head>
<body>
  <x-alert />
  <x-layout.header />
  
  <main>
    <div class="text title">책 대여 유저 조회</div>

    <div class="calendar-header">
      <div class="calendar-nav">
        <a href="?year={{ $month == 1 ? $year - 1 : $year }}&month={{ $month == 1 ? 12 : $month - 1 }}" class="button default">이전 달</a>
        <span class="text medium">{{ $year }}년 {{ $month }}월</span>
        <a href="?year={{ $month == 12 ? $year + 1 : $year }}&month={{ $month == 12 ? 1 : $month + 1 }}" class="button default">다음 달</a>
      </div>
    </div>
    
    <table class="calendar">
      <thead>
        <tr>
          <th>일</th>
          <th>월</th>
          <th>화</th>
          <th>수</th>
          <th>목</th>
          <th>금</th>
          <th>토</th>
        </tr>
      </thead>
      <tbody>
        @php
          $weeks = array_chunk($calendar, 7);
        @endphp
        
        @foreach($weeks as $week)
        <tr>
          @foreach($week as $day)
            @if($day === null)
              <td class="empty"></td>
            @else
              @php
                $dateKey = $day->format('Y-m-d');
                $dayRentals = $rentals->get($dateKey, collect());
                $isToday = $day->isToday();
              @endphp
              
              <td class="{{ $isToday ? 'today' : '' }}">
                <div class="text small">
                  {{ $day->day }}
                </div>
                
                @foreach($dayRentals->take(3) as $rental)
                  <div class="rental-item" onclick="location.href='{{ route('store_admin.users.profile', $rental->user) }}'">
                    {{ $rental->user->username }}
                  </div>
                @endforeach
                
                @if($dayRentals->count() > 3)
                  <div class="text small" style="color: #666; margin-top: 3px;">
                    +{{ $dayRentals->count() - 3 }}개 더보기
                  </div>
                @endif
              </td>
            @endif
          @endforeach
        </tr>
        @endforeach
      </tbody>
    </table>
  </main>
</body>
</html>