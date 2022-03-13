@extends('index')

@section('title')
    Личная статистика
@endsection

@section('content')
    <div class="row statisticBlock">
        <div class="d-none" id="groupData">
            {{ json_encode($groupByDate) }}
        </div>
        @foreach($groupByDate as $key => $item)
            <div class="col-md-6">
                <p class="text-center"><b>{{$key}} год</b></p>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Начало отпуска</th>
                        <th scope="col">Конец отпуска</th>
                        <th scope="col">Количество дней</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($item as $value)

                        <tr>
                            <th scope="row">{{$value->id}}</th>
                            <td>{{ $value->date_start }}</td>
                            <td>{{ $value->date_finish }}</td>
                            <td>{{ $value->number_of_days }}</td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
                <input type="hidden" value="{{ $organization->max_duration_of_vacation }}" class="max_days">
                <div class="page-content page-container" id="page-content">
                    <div class="padding">
                        <div class="row">
                            <div class="container-fluid">
                                    <div class="card">
                                        <div class="card-header"></div>
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
            let max_days = document.querySelector('.max_days').value;
            data = JSON.parse(data[0].innerText);
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
