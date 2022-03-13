@extends('index')

@section('title')
    Dashboard|Заявки
@endsection

@section('content')

    <div class="mainApplicationsTableBlock">
        @if (session()->has('ErrorDate'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    {{ session('ErrorDate') }}
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Добавить заявку
        </button>
        <table class="table mainApplicationsTable">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Дата подачи заявки</th>
                <th scope="col">Дата начала отпуска</th>
                <th scope="col">Дата конца отпуска</th>
                <th scope="col">Статус</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($applications as $application)
                <tr>
                    <input class="user_id" type="hidden" value="{{ $application->user_id }}">
                    <th scope="row">{{ $application->id }}</th>
                    <td>{{ $application->created_at }}</td>
                    <td>{{ $application->date_start }}</td>
                    <td>{{ $application->date_finish }}</td>
                    <td>{{ $application->status }}</td>
                    @if($application->status == \App\Classes\ApplicationStatusEnum::CONFIRMED)
                        <td>
                            <form method="get" action="{{ route('pdf') }}">
                                <input type="hidden" name="id" value="{{$application->id}}">
                                <button type="submit" class="btn btn-primary">Печать</button>
                            </form>
                        </td>
                    @elseif($application->status == \App\Classes\ApplicationStatusEnum::WAITING)
                        <td>
                            <button class="btn btn-outline-success updateApplication" data-id="{{ $application->id }}"
                                    data-toggle="modal" data-target="#updateModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                            </button>
                        </td>
                        <td>
                            <form method="post" action="{{ route('delete.application') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{$application->id}}">
                                <button type="submit" class="btn btn-outline-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-basket" viewBox="0 0 16 16">
                                        <path
                                            d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        <div id="calendar"></div>

    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавление заявки</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('add.application') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputDate">Введите дату начала отпуска:</label>
                            <input type="date" name="date_start" class="form-control" required>
                            <div class="valid-feedback">
                                Отлично!
                            </div>
                            <div class="invalid-feedback">
                                Выберите дату начала отпуска
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDate">Введите дату конца отпуска:</label>
                            <input type="date" name="date_finish" class="form-control" required>
                            <div class="valid-feedback">
                                Отлично!
                            </div>
                            <div class="invalid-feedback">
                                Выберите дату конца отпуска
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDate">Введите текстовый комментарий (необязательно)</label>
                            <textarea class="form-control" name="comment"></textarea>
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

    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Изменение заявки</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('update.application') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" class="update_id" value="">
                        <div class="form-group">
                            <label for="inputDate">Введите дату начала отпуска:</label>
                            <input type="date" value="" name="date_start" class="form-control date_start_value"
                                   id="date_start_value" required>
                            <div class="valid-feedback">
                                Отлично!
                            </div>
                            <div class="invalid-feedback">
                                Выберите дату начала отпуска
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDate">Введите дату конца отпуска:</label>
                            <input type="date" name="date_finish" class="form-control date_finish_value" required>
                            <div class="valid-feedback">
                                Отлично!
                            </div>
                            <div class="invalid-feedback">
                                Выберите дату конца отпуска
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDate">Введите текстовый комментарий (необязательно)</label>
                            <textarea class="form-control comment" name="comment"></textarea>
                        </div>
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
        $(document).ready(function () {
            $('.updateApplication').click(function () {
                let id = $(this).data('id');
                console.log(id);
                document.querySelector('.update_id').value = id;
                $.ajax({
                    url: 'http://localhost:8000/api/application/' + id,
                    type: "GET",
                    success: function (data) {
                        document.querySelector('.date_start_value').value = data['date_start'];
                        document.querySelector('.date_finish_value').value = data['date_finish'];
                        document.querySelector('.comment').value = data['comment'];
                    }
                });
            });
        });
    </script>
@endsection
