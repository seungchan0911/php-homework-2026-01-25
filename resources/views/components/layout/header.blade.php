<header>
  <a href="/"><div class="header__logo">서점모아</div></a>
  @guest
  <div class="guest-nav">
    <a href="/" class="button default">회원가입</a>
    <a href="login" class="button default">로그인</a>
  </div>
  @endguest
  @auth
  <div class="auth-nav">
    @if(auth()->user()->role == 2)
    <a class="button default" href="{{ route('super_admin.users') }}">유저 리스트 조회</a>
    <a class="button default" href="{{ route('stores.create') }}">서점 등록</a>
    <a class="button default" href="{{ route('super_admin.register') }}">서점 관리자 등록</a>
    @elseif(auth()->user()->role == 1)
    <a class="button default" href="{{ route('store_admin.rentals.calendar') }}">책 대여 유저 조회 (캘린더)</a>
    <a class="button default" href="{{ route('store_admin.rentals.table_view') }}">책 대여 유저 조회 (표)</a>
    <a class="button default" href="{{ route('books.create') }}">도서 등록</a>
    @else
    <a class="button default" href="{{ route('mypage') }}">{{ auth()->user()->username }}님</a>
    @endif
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button class="button default">로그아웃</button>
    </form>
  </div>
  @endauth
</header>