@extends('admin/index')

@section('title')
    Admin|History|Параметры системы
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
                <th scope="col">Что изменили</th>
                <th scope="col">Старое значение</th>
                <th scope="col">Новое значение</th>
                <th scope="col">Дата изменения</th>
            </tr>
            </thead>
            <tbody>
            @foreach($systemHistories as $systemHistory)
                <tr>
                    <th scope="row">{{ $systemHistory->id }}</th>
                    <td>{{ $systemHistory->users->email }}</td>
                    <td>{{ $systemHistory->name }}</td>
                    <td>{{ $systemHistory->last_value }}</td>
                    <td>{{ $systemHistory->new_value }}</td>
                    <td>{{ $systemHistory->created_at }}</td>
                </tr>
            @endforeach

            </tbody>
        </table>
        {{ $systemHistories->links() }}
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
                <form action="{{ route('clear.system.history') }}" method="post">
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
