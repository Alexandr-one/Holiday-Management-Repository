<?php

namespace App\Repositories\Admin;

use App\Classes\UserRolesEnum;
use App\Classes\UserStatusEnum;
use App\Organization;
use App\Position;
use App\Repositories\Admin\History\SystemHistoryRepository;
use App\Repositories\Admin\History\UserHistoryRepository;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserRepository
{
    /** @var SystemHistoryRepository */
    protected $userHistoryRepository;

    public function __construct(
        UserHistoryRepository $userHistoryRepository
    )
    {
        $this->userHistoryRepository = $userHistoryRepository;
    }

    /**
     * Showing users
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function showUsers()
    {
        return User::all();
    }

    public function updateUser(User $auth, $requestData)
    {
        $user = User::findorfail(Arr::get($requestData,'id'));
        if ($user) {
            $this->userHistoryRepository->createHistory($auth, $user, Arr::only($requestData, ['fio','fio_parent_case','email','address']));
            $user->fio = Arr::get($requestData,'fio');
            $user->fio_parent_case = Arr::get($requestData,'fio_parent_case');
            $user->email = Arr::get($requestData,'email');
            $user->address = Arr::get($requestData,'address');
            $user->save();
        }

        return $user;
    }

    /**
     * Showing posts
     * @return Position[]|\Illuminate\Database\Eloquent\Collection
     */
    public function showPosts()
    {
        return Position::all();
    }

    /**
     * Creating user
     * @param $requestData
     * @return bool
     */
    public function createUser($requestData)
    {
        $user = User::where('email', Arr::get($requestData,'email'))->first();

        if (!$user) {
            User::create([
                'email' => Arr::get($requestData,'email'),
                'position_id' => Arr::get($requestData,'post_id'),
                'role' => Arr::get($requestData,'role'),
                'status' => UserStatusEnum::WAITING,
                'password' => Hash::make(Str::random(20)),
            ]);
            $email = Arr::get($requestData, 'email');
            $user = User::where('email', $email)->first();
            $token = \Illuminate\Support\Str::random(24);
            $user->reset_token = $token;
            $user->save();
            $posts = "Ваш код подтверждения:".$token." Перейдите по ссылке: localhost:8000/password/change и добавьте пароль ";
            $name = "Holiday Management System";
            $title = "Добавление пароля";
            Mail::raw($posts,function($message) use ($email,$name,$title){
                $message->to($email , 'To web dev blog')->subject($title);
                $message->from('2004sasharyzhakov@gmail.com',$name);
            });
        } else {
            $user = false;
        }

        return $user;
    }

    /**
     * Блокировка пользователя
     *
     * @param $requestData
     * @return bool
     */
    public function blockUser($requestData)
    {
        $adminCount = User::where('role', UserRolesEnum::ADMIN)->count();
        $user = User::findOrfail(Arr::get($requestData,'user_id'));
        if ($user) {

            if ($user->role === UserRolesEnum::ADMIN &&
                $adminCount === 1 &&
                Arr::get($requestData,'role') !== UserRolesEnum::ADMIN) {
                $user = false;
            } else {
                if ($user == Auth::user())
                {
                    Auth::logout();
                }
                $user->status = UserStatusEnum::BLOCKED;
                $user->blocked_reason = Arr::get($requestData,'blocked_reason');
                $user->save();

                $user = true;
            }
        }

        return $user;
    }

    /**
     * unblocking the user
     * @param $requestData
     * @return bool
     */
    public function unblockUser($requestData)
    {
        $user = User::findOrfail(Arr::get($requestData,'user_id'));
        if ($user) {
            $user->status = UserStatusEnum::ACTIVE;
            $user->blocked_reason = null;
            $user->save();
            $user = true;
        }
        return $user;
    }

    public function updatePost(User $auth, array $requestData = [])
    {
        $user = User::findorfail(Arr::get($requestData,'user_id'));
        if ($user) {
            $this->userHistoryRepository->createHistory($auth, $user, Arr::only($requestData, ['position_id']));
            $user->position_id = Arr::get($requestData,'position_id');
            $user->save();
            $user = true;
        }

        return $user;
    }

}
