<?php

namespace App\Repositories;

use App\Classes\UserStatusEnum;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthRepository
{
    /**
     * @param $requestData
     * @param $error
     * @return mixed
     */
    public function login($requestData, &$error)
    {
        $user = User::where('email', Arr::get($requestData, 'email'))->first();
        if ($user->status != UserStatusEnum::BLOCKED) {
            if (!Auth::attempt(Arr::only($requestData, ['email', 'password']))) {
                $error = "Неверно введены данные";
            } else {
                if ($user->fio == null || $user->fio_parent_case == null || $user->address == null) {
                    $user->status = UserStatusEnum::WAITING;
                    $user->save();
                }
            }
        }
        else {
            $error = 'Вы заблокированы. Причина: ' . $user->blocked_reason;
        }

        return $user;
    }
}
