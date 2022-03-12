<?php

namespace App\Repositories;

use App\Repositories\Admin\History\UserHistoryRepository;
use App\User;
use Illuminate\Support\Arr;

class AccountRepository
{
    protected $userHistoryRepository;

    public function __construct(
        UserHistoryRepository $userHistoryRepository
    )
    {
        $this->userHistoryRepository = $userHistoryRepository;
    }

    public function update(User $user,$requestData)
    {
        $this->userHistoryRepository->createHistory($user, $user, Arr::only($requestData, ['fio','fio_parent_case','email','address']));
        $user->fio = Arr::get($requestData,'fio');
        $user->fio_parent_case = Arr::get($requestData,'fio_parent_case');
        $user->email = Arr::get($requestData,'email');
        $user->address = Arr::get($requestData,'address');
        $user->save();

        return $user;
    }
}
