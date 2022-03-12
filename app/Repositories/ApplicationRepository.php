<?php

namespace App\Repositories;

use App\Application;
use App\Classes\ApplicationStatusEnum;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ApplicationRepository
{
    /**
     * Получение заявок
     *
     * @param $user
     * @return mixed
     */
    public function index($user)
    {
        return Application::where('user_id',$user->id)->get();
    }

    /**
     * Удаление заявки
     *
     * @param $requestData
     * @return mixed
     */
    public function deleteApplication($requestData)
    {
        return Application::findorfail(Arr::get($requestData,'id'));
    }

    /**
     * Добавление заявки
     *
     * @param $requestData
     */
    public function addApplication($user,$date1,$date2,$requestData,$diff)
    {
        Application::create([
            'user_id' => $user->id,
            'date_start' => $date1,
            'date_finish' => $date2,
            'status' => ApplicationStatusEnum::WAITING,
            'comment' => Arr::get($requestData,('comment')) ? Arr::get($requestData,('comment')) : ' ',
            'number_of_days' => $diff,
        ]);
    }

    /**
     * Изменение заявки
     *
     * @param $application
     * @param $date1
     * @param $date2
     * @param $comment
     * @param $diff
     * @return mixed
     */
    public function updateApplication($application,$date1,$date2,$comment,$diff)
    {
        $application->date_start = $date1;
        $application->date_finish = $date2;
        $application->comment = $comment ? $comment : ' ';
        $application->number_of_days = $diff;
        $application->save();
        return $application;
    }
}
