@if($errors->any())<script>alert( '{{ $errors->first() }}' )</script>@endif
@if(isset($message))<script>alert( '{{ $message }}' )</script>@endif
@if(session('message'))<script>alert( "{{ session('message') }}" )</script>@endif