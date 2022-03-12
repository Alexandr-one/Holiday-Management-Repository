@extends('index')

@section('title')
     Dashboard|Заявки|Руководитель
@endsection

@section('content')
    <div style="margin-top: 100px;">
        @if (session()->has('ErrorConfirmation'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    {{ session('ErrorConfirmation') }}
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
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

        <form method="get" action="{{ route('index.director') }}">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                        Добавить заявку
                    </button>
                    </div>
                <div class="col-md-2">

                    <select class="form-select" name="user_id" aria-label="Default select example">
                        <option value="{{ $getUser? $getUser->id : ' '}}" selected>{{ $getUser ? $getUser->email : "Выберите пользователя"}}</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->email }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="status" aria-label="Default select example">
                        <option selected value="{{$getStatus ? $getStatus : ' '}}">{{ $getStatus ? $getStatus : "Выберите статус" }}</option>
                        <option value="{{ \App\Classes\ApplicationStatusEnum::CONFIRMED }}">{{ \App\Classes\ApplicationStatusEnum::CONFIRMED }}</option>
                        <option value="{{ \App\Classes\ApplicationStatusEnum::WAITING }}">{{ \App\Classes\ApplicationStatusEnum::WAITING }}</option>
                        <option value="{{ \App\Classes\ApplicationStatusEnum::REFUSED }}">{{ \App\Classes\ApplicationStatusEnum::REFUSED }}</option>
                    </select>
                </div>
                <div class="col-md-2 row">
                    <div class="col-md-6">
                        <button class="btn btn-primary" type="submit">Поиск</button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-secondary" type="button" href="{{route('index')}}">Сбросить</a>
                    </div>
                </div>

        </div>
            </form>

        <table class="table" style="margin-top: 20px;">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Дата подачи заявки</th>
                <th scope="col">Чья заявка</th>
                <th scope="col">Дата начала отпуска</th>
                <th scope="col">Дата конца отпуска</th>
                <th scope="col">Статус</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <input class="user_id" type="hidden" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
            @foreach($applications as $application)
                <tr>

                    <th scope="row">{{ $application->id }}</th>
                    <td>{{ $application->created_at }}</td>
                    <td>{{ $application->users->email }}</td>
                    <td>{{ $application->date_start }}</td>
                    <td>{{ $application->date_finish }}</td>
                    <td>{{ $application->status }}</td>
                    @if($application->status == \App\Classes\UserStatusEnum::WAITING)
                    <td>
                        <button class="btn btn-outline-success confirm"  data-toggle="modal" data-target="#exampleModal" data-id="{{ $application->id }}">
                            Утвердить
                        </button>
                        <button type="submit" class="btn btn-outline-danger refuse"  data-toggle="modal" data-target="#refusedModal" data-id="{{ $application->id }}">
                            Отклонить
                        </button>
                    </td>
                    @if($application->user_id == \Illuminate\Support\Facades\Auth::user()->id)
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
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $applications->appends($_GET)->links() }}
            <div id="calendar"></div>
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
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Утверждение</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ route('confirm.application') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" class="form-control confirm_app_id" id="" value="" name="id">
                            <p>Вы уверены, что хотите утвердить эту заявку?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-primary">Утвердить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="refusedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Отклонение</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ route('refuse.application') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" class="form-control refuse_app_id" id="" value="" name="id">
                            <p>Вы уверены, что хотите отклонить эту заявку?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-primary">Отклонить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                            console.log(data);
                        }
                    });
                });
            });
            $(document).ready(function (){
               $('.refuse').click(function () {
                   let id = $(this).data('id');
                   document.querySelector('.refuse_app_id').value = id;
               });
               $('.confirm').click(function () {
                  let id = $(this).data('id');
                   document.querySelector('.confirm_app_id').value = id;
               });
            });
        </script>
            <script>
                const cal = document.getElementById('calendar');
                const hdr = '<div>пн</div><div>вт</div><div>ср</div><div>чт</div><div>пт</div><div>сб</div><div>вс</div>';
                const getTitle = (d, y) => `<div class="title">${d + 1 + '.' + y}</div>`;
                let first_date = '';
                let sec_date = '';
                let id = document.querySelector('.user_id').value;
                $.ajax({
                    url: 'http://localhost:8000/api/application/',
                    type: "GET",
                    data: {user_id: id},
                    success: function (data) {
                        first_date = data[0][0]['date_start'];
                        sec_date = data[1][data[1].length - 1]['date_finish'];
                        let dStart = new Date(`${first_date}`);
                        let dEnd = new Date(`${sec_date}`);
                        let ds = new Date(dStart);
                        let de = new Date(dEnd);
                        ds.setDate(1);
                        de.setMonth(dEnd.getMonth() + 1, 1);
                        de.setHours(0, 0, 0, 0);
                        let date = [];
                        let eMonth = null;
                        for (let i = 0; i < data[0].length; i++) {
                            date.push([data[0][i]['date_start'], data[0][i]['date_finish'], data[0][i]['status']]);
                        }
                        while (ds < de) {
                            let day = ds.getDate();
                            let dayOfWeek = ds.getDay() == 0 ? 7 : ds.getDay();
                            let dayDiv = document.createElement('div');

                            if (day == 1) {
                                cal.appendChild(eMonth = document.createElement('div'));
                                eMonth.innerHTML = getTitle(ds.getMonth(), ds.getFullYear()) + hdr;
                                dayDiv.style.gridColumn = dayOfWeek;
                            }
                            for (let i = 0; i < date.length; i++) {
                                let dateStart = new Date(`${date[i][0]}`);
                                let dateFinish = new Date(`${date[i][1]}`);
                                let status = date[i][2];
                                dayDiv.innerText = day;
                                if (ds >= dateStart && ds <= dateFinish) {
                                    if (status == 'CONFIRMED') {
                                        if (dayDiv.style.background == 'green') {
                                            dayDiv.style.background = 'green'
                                        }
                                        else if (dayDiv.style.background == 'red') {
                                            dayDiv.style.background = 'linear-gradient(green 50%, red 50%)'
                                        }
                                        else if (dayDiv.style.background == 'orange') {
                                            dayDiv.style.background = 'linear-gradient(green 50%, orange 50%)';
                                        }
                                        else if(dayDiv.style.background == 'linear-gradient(green 50%, red 50%)') {
                                            dayDiv.style.background = 'linear-gradient(green 50%, red 50%)'
                                        }
                                        else if(dayDiv.style.background == 'linear-gradient(green 50%, orange 50%)') {
                                            dayDiv.style.background = 'linear-gradient(green 50%, orange 50%)'
                                        }
                                        else if(dayDiv.style.background == 'linear-gradient(red 50%, orange 50%)') {
                                            dayDiv.style.background = 'linear-gradient(red 25%, green 50%, orange 80%)'
                                        }
                                        else if(dayDiv.style.background == 'linear-gradient(red 25%, green 50%, orange 80%)')
                                        {
                                            dayDiv.style.background = 'linear-gradient(red 25%, green 50%, orange 80%)'
                                        }
                                        else {
                                            dayDiv.style.background = 'green'
                                        }
                                    }
                                    else if (status == 'WAITING') {
                                        if (dayDiv.style.background == 'orange') {
                                            dayDiv.style.background = 'orange'
                                        }
                                        else if (dayDiv.style.background == 'red') {
                                            dayDiv.style.background = 'linear-gradient(red 50%, orange 50%)'
                                        }
                                        else if (dayDiv.style.background == 'green') {
                                            dayDiv.style.background = 'linear-gradient(green 50%, orange 50%)';
                                        }
                                        else if(dayDiv.style.background == 'linear-gradient(red 50%, orange 50%)') {
                                            dayDiv.style.background = 'linear-gradient(red 50%, orange 50%)'
                                        }
                                        else if(dayDiv.style.background == 'linear-gradient(green 50%, orange 50%)') {
                                            dayDiv.style.background = 'linear-gradient(green 50%, orange 50%)'
                                        }
                                        else if(dayDiv.style.background == 'linear-gradient(green 50%, red 50%)') {
                                            dayDiv.style.background = 'linear-gradient(red 25%, green 50%, orange 80%)'
                                        }
                                        else if(dayDiv.style.background == 'linear-gradient(red 25%, green 50%, orange 80%)')
                                        {
                                            dayDiv.style.background = 'linear-gradient(red 25%, green 50%, orange 80%)'
                                        }
                                        else {
                                            dayDiv.style.background = 'orange'
                                        }
                                    }
                                    else if(status == 'REFUSED') {
                                        if (dayDiv.style.background == 'red') {
                                            dayDiv.style.background = 'red'
                                        }
                                        else if (dayDiv.style.background == 'green') {
                                            dayDiv.style.background = 'linear-gradient(green 50%, red 50%)'
                                        }
                                        else if (dayDiv.style.background == 'orange') {
                                            dayDiv.style.background = 'linear-gradient(red 50%,orange 50%)';
                                        }
                                        else if(dayDiv.style.background == 'linear-gradient(green 50%, red 50%)') {
                                            dayDiv.style.background = 'linear-gradient(green 50%, red 50%)'
                                        }
                                        else if(dayDiv.style.background == 'linear-gradient(red 50%, orange 50%)') {
                                            dayDiv.style.background = 'linear-gradient(red 50%, orange 50%)'
                                        }
                                        else if(dayDiv.style.background == 'linear-gradient(green 50%, orange 50%)') {
                                            dayDiv.style.background = 'linear-gradient(red 25%, green 50%, orange 80%)'
                                        }
                                        else if(dayDiv.style.background == 'linear-gradient(red 25%, green 50%, orange 80%)')
                                        {
                                            dayDiv.style.background = 'linear-gradient(red 25%, green 50%, orange 80%)'
                                        }
                                        else {
                                            dayDiv.style.background = 'red'
                                        }
                                    }

                                }
                            }
                            eMonth.appendChild(dayDiv);
                            ds.setDate(ds.getDate() + 1);
                        }
                    }
                });

            </script>
            <style>
                #calendar {
                    display: flex;
                    flex-wrap: wrap;
                }

                #calendar > div {
                    display: grid;
                    grid-template-columns: repeat(7, 30px);
                    grid-template-rows: 30px;
                    column-gap: 2px;
                    row-gap: 2px;
                    margin: 12px 7px;
                }

                #calendar > div > div {
                    text-align: center;
                }

                .title {
                    grid-column: span 7;
                }

                .holiday {
                    color: red;
                }

                .not-in-range {
                    color: lightgray;
                }

                @media (min-width: 1200px) and (max-width: 1285px) {

                }
            </style>
@endsection

