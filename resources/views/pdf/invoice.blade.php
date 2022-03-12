<!DOCTYPE html>
<html>
<head>
    <title>Invoice Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script></head>
<body>
<div class="main">
    <div style="font-size: 20px;margin-top:100px;">
        <div style="margin-left: 350px;">
            <p>Директору компании {{ $organization->name }}</p>
            <p>{{ $organization->director->fio }}</p>
            <p >{{$user->post->name_parent_case}}</p>
            <p >{{$user->fio_parent_case}}</p><br>
        </div>
        <div style="margin-top: 50px;">
            <h1 class="text-center">Заявление</h1><br>
            <p style="font-size: 25px;text-indent: 50px;">Прошу предоставить мне очередной отпуск сроком на {{$application->number_of_days}} дней с {{ $application->date_start }} по {{ $application->date_finish }}.</p>
        </div>
        <br>
    </div>
</div>
<p style="font-size: 20px;margin-left: 450px">(подпись)</p>


</body>
</html>
