@extends('auth/index')
@section("title")
    Восстановление пароля
@endsection
@section("content")
    <form method="post" action="{{route('password.change')}}">
        @csrf
        <img class="mb-4" src="https://cdn.pixabay.com/photo/2017/01/31/20/40/calendar-2027122_1280.png" alt="" width="100" height="100">
        <h1 class="h3 mb-3 fw-normal reset_password_label">Восстановление пароля</h1>
        @if (session()->has('errorCode'))
            <div class="alert alert-danger">
                {{ session('errorCode') }}
            </div>
        @endif
        @error('code')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @enderror
        <div class="form-floating">
            <input type="text" name="code" class="form-control input_reset_password" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Код</label>
        </div>
        @error('password')
        <div class="alert alert-danger alertErrors">
            {{ $message }}
        </div>
        @enderror
        <div class="form-floating">
            <input type="password" name="password" class="form-control input_reset_password" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Пароль</label>
        </div>
        @error('password_confirm')
        <div class="alert alert-danger alertErrors">
            {{ $message }}
        </div>
        @enderror
        <div class="form-floating">
            <input type="password" name="password_confirm" class="form-control input_reset_password" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Подтвердите пароль</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary " type="submit">Отправить</button>
        <p class="mt-5 mb-3 text-muted">&copy;Holiday Management System, 2022</p>
    </form>
@endsection
