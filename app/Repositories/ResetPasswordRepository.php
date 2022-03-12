<?php

namespace App\Repositories;

use App\Http\Services\MailService;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetPasswordRepository
{
    /** @var MailService */
    protected $mailService;

    public function __construct(
        MailService $mailService
    )
    {
        $this->mailService = $mailService;
    }

    /**
     * @param $requestData
     * @return bool
     */
    public function change($requestData)
    {
        $userStatus = false;
        $user = User::where('reset_token', Arr::get($requestData,'code'))->first();

        if ($user) {
            $userStatus = true;
            $user->password = Hash::make(Arr::get($requestData,'password'));
            $user->save();
        }

        return $userStatus;
    }

    /**
     * @param $requestData
     * @param $error
     * @return mixed
     */
    public function sendCode($requestData, &$error)
    {
        $email = Arr::get($requestData,'email');
        $user = User::where('email', $email)->first();
        $token = \Illuminate\Support\Str::random(24);
        if ($user) {
            $user->reset_token = $token;
            $user->save();
            $posts = "Ваш код подтверждения:".$token;
            $name = "Holiday Management System";
            $title = "Восстановление пароля";
            $this->mailService->sendMail($posts, $email, $name, $title);
        } else {
            $error = 'Пользователя с такой почтой не существует';
        }

        return $user;
    }
}
