@extends('auth/index')
@section("title")
    Авторизация в системе
@endsection
@section("content")

    <form action="{{route('login')}}" method="post">
        @csrf
        <img class="mb-4" src="https://cdn.pixabay.com/photo/2017/01/31/20/40/calendar-2027122_1280.png" alt="" width="100" height="100">
        <h1 class="h3 mb-3 fw-normal">Авторизация</h1>

        @if (session()->has('loginErrors'))
            <div class="alert alert-danger">
                {{ session('loginErrors') }}
            </div>
        @endif

        @if (session()->has('successResetPassword'))
            <div class="alert alert-success">
                {{ session()->pull('successResetPassword') }}
            </div>
        @endif

        @error('email')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @enderror

        <div class="form-floating">
            <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Почта</label>
        </div>

        @error('password')
        <div class="alert alert-danger alertErrors">
            {{ $message }}
        </div>
        @enderror

        <div class="form-floating">
            <input type="password" class="form-control inputPassword" id="floatingPassword" name="password" placeholder="пароль">
            <label for="floatingPassword">Пароль</label>
        </div>

        <div class="checkbox mb-3">
            <label>
                <a href="{{route('password.reset')}}">Забыли пароль?</a>
            </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
        <p class="mt-5 mb-3 text-muted">&copy;Holiday Management System, 2022</p>
    </form>
@endsection
