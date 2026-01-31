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
    <div class="text title">유저 리스트</div>
    <table>
      <thead>
        <tr>
          <th>아이디</th>
          <th>비밀번호</th>
          <th>가입일</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr>
            <th>{{ $user->username }}</th>
            <td>{{ $user->password }}</td>
            <td>{{ $user->created_at->format('20y-m-d') }}</td>
            <td class="text small">{{ $user->role ? '상점 관리자' : ''}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </main>
  <x-alert />
</body>
</html>