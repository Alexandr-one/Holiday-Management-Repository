@extends('admin/index')

@section('title')
    Пользователи
@endsection

@section('content')
    <div class="container mainPostsContainerBlock">

        @if (session()->has('deleteError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('deleteError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('createSuccess'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('createSuccess') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('updateSuccess'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('updateSuccess') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Добавить должность
        </button>

        <table class="table postMainTable">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Название</th>
                <th scope="col">Название в род. падеже</th>
                <th scope="col">Рабочие</th>
                <td></td>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <th scope="row">{{ $post->id }}</th>
                    <td>{{ $post->name }}</td>
                    <td>{{ $post->name_parent_case }}</td>
                    <td>
                        @foreach($post->users as $userPost)
                            {{ $userPost->email }}<br>
                        @endforeach
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning confirmUpdating" data-id="{{ $post->id }}"
                                data-toggle="modal" data-target="#confirmUpdating">
                            Изменить
                        </button>
                        <button type="button" class="btn btn-outline-danger confirmDeleting" data-id="{{ $post->id }}"
                                data-toggle="modal" data-target="#confirmDeleting">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-basket" viewBox="0 0 16 16" data-darkreader-inline-fill=""
                                 style="--darkreader-inline-fill:currentColor;">
                                <path
                                    d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z"></path>
                            </svg>
                            <span class="visually-hidden">Button</span>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $posts->links() }}
    </div>
    <div class="modal fade" id="confirmUpdating" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Изменение</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('update.post') }}" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" class="form-control post_id_update" name="id" id="post_id">
                        <div>
                            <label for="name">Название должности</label>
                            <input name="name" class="form-control name" id="name" required>
                            <div class="valid-feedback">
                                Отлично
                            </div>
                            <div class="invalid-feedback">
                                Введите должность
                            </div>
                        </div>
                        <div>
                            <label for="name_parent_case">Название должности в род. падеже</label>
                            <input name="name_parent_case" class="form-control name_parent_case" id="name_parent_case"
                                   required>
                            <div class="valid-feedback">
                                Отлично
                            </div>
                            <div class="invalid-feedback">
                                Введите должность в род.падеже
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-warning">Изменить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmDeleting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Подтверждение удаления</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('delete.post') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" class="post_id" name="post_id" id="post_id">
                        <p>Вы действительно хотите удалить эту должность?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавление должности</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('add.post') }}" class="row g-3 needs-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        <input class="form-control" type="text" placeholder="Название должности" name="name" required>
                        <div class="valid-feedback">
                            Отлично
                        </div>
                        <div class="invalid-feedback">
                            Введите должность
                        </div>
                        <input class="form-control" type="text" placeholder="Название должности в род. падеже"
                               name="name_parent_case" style="margin-top: 10px;" required>
                        <div class="valid-feedback">
                            Отлично
                        </div>
                        <div class="invalid-feedback">
                            Введите должность
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                </form>


            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.confirmDeleting').click(function () {
                let id = $(this).data('id');
                document.querySelector('.post_id').value = id;
            });
            $('.confirmUpdating').click(function () {
                let id = $(this).data('id');
                //document.querySelector('.post_id_udpate').value = id;
                $.ajax({
                    url: 'http://localhost:8000/api/admin/post/' + id,
                    type: "GET",
                    success: function (data) {
                        document.querySelector('.post_id_update').value = data['id'];
                        document.querySelector('.name').value = data['name'];
                        document.querySelector('.name_parent_case').value = data['name_parent_case'];
                        console.log(data);
                    }
                });
            });
        });
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
        .mainPostsContainerBlock {
            margin-top: 80px;
        }

        .postMainTable {
            margin-top: 40px;
        }
    </style>
@endsection
