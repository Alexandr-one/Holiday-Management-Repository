@extends('admin/index')

@section('title')
    Admin|History|Сотрудники
@endsection


@section('content')
    <div class="content mainBlock">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Очистить
        </button>
        <table class="table mainTable">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Кто изменил</th>
                <th scope="col">У кого изменил</th>
                <th scope="col">Что изменили</th>
                <th scope="col">Старое значение</th>
                <th scope="col">Новое значение</th>
                <th scope="col">Дата изменения</th>
            </tr>
            </thead>
            <tbody>
            @foreach($usersHistory as $userHistory)
                <tr>
                    <th scope="row">{{ $userHistory->id }}</th>
                    <td>{{ $userHistory->auth->email }}</td>
                    <td>{{ $userHistory->users->email }}</td>
                    <td>{{ $userHistory->name }}</td>
                    <td>{{ $userHistory->last_value }}</td>
                    <td>{{ $userHistory->new_value }}</td>
                    <td>{{ $userHistory->created_at }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
        {{ $usersHistory->appends($_GET)->links() }}
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Подтверждение очищения</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('clear.users.history') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <p> вы уверены, что хотите очистить историю? </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Очистить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .mainTable{
            margin-top: 20px;
        }
        .mainBlock{
            margin-top: 100px;
            margin-left: 50px;
            margin-right: 50px;
        }
    </style>
@endsection
