@extends('admin/index')

@section('title')
    Admin|Изменение пользователя
@endsection

@section('content')
<div class="container" style="margin-top: 100px;">
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
    @if (session()->has('updateError'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('updateError') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h3>Изменение пользователя {{ $user->email }}</h3>
    <form method="post" action="{{ route('user_update') }}" class="row g-3 needs-validation" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $user->id }}">
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label">ФИО сотрудника</label>
            <input type="text" class="form-control" name="fio" id="validationCustom01" value="{{$user->fio}}" required>
            <div class="valid-feedback">
                Отлично!
            </div>
            <div class="invalid-feedback">
                Введите ФИО сотрудника
            </div>
        </div>
        <div class="col-md-6">
            <label for="validationCustom01" class="form-label">ФИО сотрудника в род. падеже</label>
            <input type="text" class="form-control" name="fio_parent_case" id="validationCustom01" value="{{$user->fio_parent_case}}" required>
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
                <input type="text" name="email" value="{{ $user->email }}" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
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
            <input type="text" class="form-control" name="address" id="validationCustom01" value="{{$user->address}}" required>
            <div class="valid-feedback">
                Отлично!
            </div>
            <div class="invalid-feedback">
                Введите адрес
            </div>
        </div>


        <div class="col-12 buttonChangeUserSubmit">
            <button class="btn btn-primary" type="submit">Изменить</button>
        </div>
    </form>

</div>
<script>
    (function () {
        'use strict'
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
<style>
    .buttonChangeUserSubmit{
        margin-top:50px;
    }
</style>
@endsection
