@extends('admin/index')

@section('title')
    Admin|Главная
@endsection

@section('content')
        <div class="jumbotron" style="margin-top: 50px;">
            <div class="container text-center">
                <img width="200px" height="200px" src="https://cdn.pixabay.com/photo/2017/01/31/20/40/calendar-2027122_1280.png">
                <h1 class="display-3 ">{{ $organization->name }}</h1>
                <p><b>Директор: </b>{{ $organization->director->fio }}</p>
                <p><b>Максимальная длительность отпуска: </b>{{ $organization->max_duration_of_vacation }} дней</p>
                <p><b>Минимальная длительность отпуска: </b>{{ $organization->min_duration_of_vacation }} дней</p>
                <p><a class="btn btn-primary btn-lg" href="{{ route('admin.edit.page') }}" role="button">Изменить</a></p>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2>Сотрудники</h2>
                    <p>Cотрудники имеют возможность просматривать, добавлять, редактировать и удалять заявки на отпуск, просматривать свою статискику и генерировать заявку на отпуск. Руководители могут просматривать, отклонять или принимать заявки на отпуск, редактировать основные параметры системы, добавлять и блокировать пользователей. </p>
                    <p><a class="btn btn-secondary" href="{{route('admin.users.page')}}" role="button">Перейти »</a></p>
                </div>
                <div class="col-md-4">
                    <h2>Должности</h2>
                    <p>Справочник должностей <br>
                        ●	добавление, удаление и редактирование должностей;<br>
                        ●	нельзя удалять должности, на которых есть сотрудники;<br>
                        ●	у должности должно быть два поля: название и название в родительном падеже (для печати заявления).
                    </p>
                    <p><a class="btn btn-secondary" href="{{ route('admin.posts.page') }}" role="button">Перейти »</a></p>
                </div>
                <div class="col-md-4">
                    <h2>Истории</h2>
                    <p>Таблицы, содержащие в себе действия пользователей по изменению параметров системы, личных данных и статусов заявок</p>
                    <p><a class="btn btn-secondary" href="{{ route('system.history') }}" >Перейти » Истории изменения параметров системы</a></p>
                    <p><a class="btn btn-secondary" href="{{ route('users.history') }}" >Перейти » Истории изменения сотрудников</a></p>
                    <p><a class="btn btn-secondary" href="{{ route('application.status.history') }}" >Перейти » Истории изменения статусов заявок</a></p>

                </div>
            </div>
            <hr>
        </div>
@endsection
