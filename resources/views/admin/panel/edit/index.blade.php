@extends('admin/index')

@section('title')
    Admin|Изменение организации
@endsection

@section('content')

    <div class="container" style="margin-top: 100px;">
        @if (session()->has('updateError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('updateError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h3>Изменение параметров системы</h3>
        <form method="post" action="{{ route('admin.update') }}" class="row g-3 needs-validation" novalidate>
            @csrf
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Название организации</label>
                <input type="text" class="form-control" name="name" id="validationCustom01" value="{{$organization->name}}" required>
                <div class="valid-feedback">
                    Отлично!
                </div>
                <div class="invalid-feedback">
                    Введите название организации
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom04" class="form-label">Новый директор</label>
                <select class="form-select" name="director_id" id="validationCustom04" required>
                    <option selected disabled value="">Выберите среди руководителей</option>
                    @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->email}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Выберите директора
                </div>
                <div class="valid-feedback">
                    Отлично!
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Максимальная длительность отпуска в днях:</label>
                <input type="text" class="form-control" name="max_duration_of_vacation" id="validationCustom01" value="{{$organization->max_duration_of_vacation}}" required>
                <div class="valid-feedback">
                    Отлично!
                </div>
                <div class="invalid-feedback">
                    Введите название организации
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom01" class="form-label">Минимальная длительность отпуска в днях:</label>
                <input type="text" class="form-control" name="min_duration_of_vacation" id="validationCustom01" value="{{$organization->min_duration_of_vacation}}" required>
                <div class="valid-feedback">
                    Отлично!
                </div>
                <div class="invalid-feedback">
                    Введите название организации
                </div>
            </div>

            <div class="col-12">
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
@endsection
