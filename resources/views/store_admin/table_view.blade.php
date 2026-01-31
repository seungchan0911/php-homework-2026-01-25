<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
  <link rel="stylesheet" href="{{ asset('css/user/mypage.css') }}">
</head>
<body>
  <x-alert />
  <x-layout.header />
  
  <main>
    <div class="text title">책 대여 유저 조회</div>
    
    <table>
      <thead>
        <tr>
          <th>유저</th>
          <th>책</th>
          <th>대여일</th>
          <th>반납 예정일</th>
          <th>상태</th>
          <th>관리</th>
        </tr>
      </thead>
      <tbody>
        @forelse($rentals as $rental)
        <tr class="{{ $rental->is_returned ? '' : 'active' }}">
          <th>
            <a href="{{ route('store_admin.users.profile', $rental->user) }}">
              {{ $rental->user->username }}
            </a>
          </th>
          <td>{{ $rental->book->name }}</td>
          <td>{{ $rental->created_at->format('Y-m-d') }}</td>
          <td>{{ $rental->due_date->format('Y-m-d') }}</td>
          <td>
            @if($rental->is_returned)
              반납 완료
            @else
              대여 중
            @endif
          </td>
          <td>
            @if(!$rental->is_returned)
              <form action="{{ route('return', $rental) }}" method="POST" style="display:inline;">
                @csrf
                <button class="button small">반납 처리</button>
              </form>
            @else
              <div class="button small disabled">{{ $rental->updated_at->format('Y-m-d') }} 반납</div>
            @endif
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center">대여 기록이 없어요!</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    
    <div class="pagination">
      @if ($rentals->onFirstPage())
        <span class="button small disabled">←</span>
      @else
        <a class="button small" href="{{ $rentals->previousPageUrl() }}">←</a>
      @endif
      
      <span>{{ $rentals->currentPage() }} / {{ $rentals->lastPage() }}</span>
      
      @if ($rentals->hasMorePages())
        <a class="button small" href="{{ $rentals->nextPageUrl() }}">→</a>
      @else
        <span class="button small disabled">→</span>
      @endif
    </div>
  </main>
</body>
</html>