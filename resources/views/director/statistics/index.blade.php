@extends('index')

@section('title')
    Статистика сотрудников
@endsection

@section('content')
    <div style="margin-top: 100px;" class="row">
        <div class="d-none" id="groupData">
            {{ json_encode($groupByDate) }}
        </div>
        <form method="get" action="{{ route('statistics.director') }}">
            @csrf
            <div class="row">
                <div class="col-md-2">
                    <select class="form-select" name="year" aria-label="Default select example">
                        <option value="{{ $getUser? $getUser->id : ' '}}" selected>{{ $getUser ? $getUser->email : "Выберите год"}}</option>
                        @foreach($groupByDate as $key => $item)
                            <option value="{{ $key}}">{{ $key }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="user_id" aria-label="Default select example">
                        <option selected value="{{$getUser ? $getUser : ' '}}">{{ $getUser ? $getUser : "Выберите пользователя" }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->email }}</option>
                        @endforeach
                        </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" type="submit">Поиск</button>
                    <a class="btn btn-secondary" type="button" href="{{route('statistics.director')}}">Сбросить</a>
                </div>
            </div>
        </form>
        <input type="hidden" value="{{ $organization->max_duration_of_vacation }}" class="max_days">
        @foreach($groupByDate as $key => $item)
            <div class="col-md-6" style="margin-top: 10px;">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Чей отпуск</th>
                        <th scope="col">Начало отпуска</th>
                        <th scope="col">Конец отпуска</th>
                        <th scope="col">Количество дней</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($item as $value)

                        <tr>
                            <th scope="row">{{$value->id}}</th>
                            <td>{{ $value->users->email }}</td>
                            <td>{{ $value->date_start }}</td>
                            <td>{{ $value->date_finish }}</td>
                            <td>{{ $value->number_of_days }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <div class="page-content page-container" id="page-content">
                    <div class="padding">
                        <div class="row">
                            <div class="container-fluid">
                                <div class="card">
                                    <div class="card-header">Статистика за {{ $key }}</div>
                                    <div class="card-body">
                                        <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                            <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                            </div>
                                        </div> <canvas id="chart-line-{{$key}}" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>
    <script>
        $(document).ready(function() {
            let data = $('#groupData');
            data = JSON.parse(data[0].innerText);
            let max_days = document.querySelector('.max_days').value;
            Object.keys(data).forEach(item => {
                let countDays = 0;
                data[item].forEach(object => {
                    countDays += object.number_of_days
                })
                var ctx = $(`#chart-line-${item}`);
                var myLineChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ["Использованно", "Не использованно"],
                        datasets: [{
                            data: [countDays, max_days - countDays],
                            backgroundColor: ["rgba(255, 0, 0, 0.5)", "rgba(100, 255, 0, 0.5)"]
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: `Учет статистики за ${item} год`
                        }
                    }
                });
            })
            // data.forEach(item => {
            //     console.log(item)
            // })

        });
    </script>

@endsection
