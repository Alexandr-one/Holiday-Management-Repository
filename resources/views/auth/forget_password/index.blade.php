@extends('auth/index')
@section("title")
    Забыли пароль?
@endsection
@section("content")

    <form method="post" action="{{route('password.reset.email')}}">
        @csrf
        <img class="mb-4" src="https://cdn.pixabay.com/photo/2017/01/31/20/40/calendar-2027122_1280.png" alt=""
             width="100" height="100">
        <h1 class="h3 mb-3 fw-normal reset_password_label">Восстановление пароля</h1>
        <p class="InputEmailLabel">Введите подтвержденный адрес электронной почты вашей учетной записи пользователя, и
            мы вышлем вам ссылку для сброса пароля.</p>

        @if (session()->has('noneUser'))
            <div class="alert alert-danger">
                {{ session('noneUser') }}
            </div>
        @endif

        @error('email')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @enderror

        <div class="form-floating">
            <input type="email" value="{{ session()->has('emailReset') ? session()->pull('emailReset') : " " }}"
                   name="email" class="form-control input_reset_password" id="floatingInput"
                   placeholder="name@example.com">
            <label for="floatingInput">Почта</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary " type="submit">Отправить</button>
        <p class="mt-5 mb-3 text-muted">&copy;Holiday Management System, 2022</p>
    </form>

@endsection
