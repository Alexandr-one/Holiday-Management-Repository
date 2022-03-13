@extends('index')

@section('title')
    Личный кабинет
@endsection

@section('content')
    <div class="container mainAccountBlock">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('updateSuccess'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('updateSuccess') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('updateErrors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('updateErrors') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

            <div class="alert alert-danger alert-dismissible fade show incorrect_email" role="alert" style="display: none">
                Ошибка.Сотрудник с такой почтой найден и это не вы!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="alert alert-danger alert-dismissible fade show incorrect_date" role="alert" style="display: none">
                Введите данные!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="alert alert-success alert-dismissible fade show correct" role="alert" style="display: none">
                Ваши данные изменены!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        @if (session()->has('waitingMessage'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('waitingMessage') ? session()->pull('waitingMessage') : " " }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h3>Изменение сотрудника {{ $user->email }}</h3>
        <form class="row g-3 needs-validation" novalidate>
            <input type="hidden" name="id" value="{{ $user->id }}">
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">ФИО сотрудника</label>
                <input type="text" class="form-control FIO" name="FIO" id="validationCustom01" value="{{$user->fio}}"
                       required>
                <div class="valid-feedback">
                    Отлично!
                </div>
                <div class="invalid-feedback">
                    Введите ФИО сотрудника
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom02" class="form-label">ФИО сотрудника в род. падеже</label>
                <input type="text" class="form-control FIO_parent_case" name="FIO_parent_case" id="validationCustom02"
                       value="{{$user->fio_parent_case}}" required>
                <div class="valid-feedback">
                    Отлично!
                </div>
                <div class="invalid-feedback">
                    Введите ФИО сотрудника в род. падеже
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustomUsername" class="form-label">Почта</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="text" name="email" value="{{ $user->email }}" class="form-control email"
                           id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
                    <div class="invalid-feedback">
                        Введите почту.
                    </div>
                    <div class="valid-feedback">
                        Отлично!
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Адрес</label>
                <input type="text" class="form-control address" name="address" id="validationCustom01"
                       value="{{$user->address}}" required>
                <div class="valid-feedback">
                    Отлично!
                </div>
                <div class="invalid-feedback">
                    Введите адрес
                </div>
            </div>


            <div class="col-12 " >
                <button class="btn btn-primary buttonChangeUserSubmit" type="button" data-id="{{ $user->id }}" data-toggle="modal" data-target="#exampleModal">Изменить</button>
            </div>
        </form>

    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Изменение</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show incorrect_password" role="alert" style="display: none">
                        Вы ввели неправильный пароль!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <label for="password" class="form-label">Введите пароль для  подтверждения</label>
                    <input type="password" class="form-control confirm_password" name="password" id="confirm_password"
                           value="" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary changeValues">Изменить</button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <h3>Изменение пароля сотрудника {{ $user->email }}</h3>
        <button class="btn btn-warning" type="button" data-toggle="modal" data-target="#changeUserPasswordModal">
            Изменить
        </button>

    </div>

    <div class="modal fade" id="changeUserPasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Изменение пароля</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('change.account.password') }}">
                    @csrf
                    <div class="modal-body">

                        <input class="form-control" type="password" name="password" placeholder="Введите действующий пароль" required>
                        <input class="form-control" type="password" name="new_password" style="margin-top: 20px;"
                               placeholder="Введите новый пароль" required>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Изменить</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $('.buttonChangeUserSubmit').click(function () {
            let id = $(this).data('id');
            console.log(id);
            $('.changeValues').click(function () {
                let FIO = document.querySelector('.FIO').value;
                let FIO_parent_case = document.querySelector('.FIO_parent_case').value;
                let password = document.querySelector('.confirm_password').value;
                let address = document.querySelector('.address').value;
                let email = document.querySelector('.email').value;
                if (FIO == 0 || FIO_parent_case == 0 || password == 0 || address == 0 || email == 0) {
                    document.querySelector('.incorrect_date').style.display = 'block';
                } else {
                    console.log(FIO)
                    $.ajax({
                        url: 'http://localhost:8000/api/account/update',
                        type: "post",
                        data: {fio:FIO , fio_parent_case:FIO_parent_case, address:address, email:email,password:password, id:id },
                        success: function (data) {
                            console.log(data);
                            if (data == 2) {
                                document.querySelector('.incorrect_password').style.display = 'block';
                            } else if (data == 1) {
                                document.querySelector('.incorrect_email').style.display = 'block';
                            } else if (data == 0) {
                                window.location.reload();
                                document.querySelector('.correct').style.display = 'block';
                            }
                        }
                    });
                }

            });
        });
    </script>
@endsection
