<?php

namespace App\Repositories\Admin\History;

use App\Organization;
use App\SystemHistory;
use App\User;
use App\UserHistory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class UserHistoryRepository
{
    /**
     * get Users Histories
     * @param $requestData
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUsersHistories($requestData)
    {
        $usersHistory = UserHistory::query();
        if ($authId = Arr::get($requestData,'user_id')) {
            $usersHistory->where('auth_id', $authId);
        }
        $usersHistory = $usersHistory->paginate(10);

        return $usersHistory;
    }

    /**
     * @param User $user
     * @param Organization $organization
     * @param array $requestData
     */
    public function createHistory(User $auth, User $user, array $requestData = [])
    {
        foreach ($requestData as $key => $data) {
            $userHistory = UserHistory::create([
                'name' => $key,
                'auth_id' => $auth->id,
                'user_id' => $user->id,
                'new_value' => $data,
                'last_value' => $user->getAttribute($key)
            ]);
        }
    }
}
