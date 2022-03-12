@extends('index')

@section('title')
    Dashboard|Заявки
@endsection

@section('content')

    <div style="margin-top: 100px;">
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
        <table class="table" style="margin-top: 20px;">
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
    </style>
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
        // Example starter JavaScript for disabling form submissions if there are invalid fields
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
