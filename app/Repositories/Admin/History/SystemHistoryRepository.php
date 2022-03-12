<?php

namespace App\Repositories\Admin\History;

use App\Organization;
use App\SystemHistory;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class SystemHistoryRepository
{
    public function getSystemHistory()
    {
        return SystemHistory::paginate(10);
    }

    /**
     * @param User $user
     * @param Organization $organization
     * @param array $requestData
     */
    public function createHistory(User $user, Organization $organization, array $requestData = [])
    {
        foreach ($requestData as $key => $data) {
            $systemHistory = SystemHistory::create([
                'name' => $key,
                'user_id' => $user->id,
                'new_value' => $data,
                'last_value' => $organization->getAttribute($key)
            ]);

            Log::info('[SystemHistoryRepository] Create system history for organization: '. $systemHistory->id);
        }
    }
}
