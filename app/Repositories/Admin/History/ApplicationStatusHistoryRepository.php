<?php

namespace App\Repositories\Admin\History;

use App\Application;
use App\ApplicationStatusHistory;
use App\Organization;
use App\SystemHistory;
use App\User;
use Illuminate\Support\Facades\Log;

class ApplicationStatusHistoryRepository
{

    public function getApplicationStatusHistory()
    {
        return ApplicationStatusHistory::paginate(10);
    }

    /**
     * @param User $user
     * @param Organization $organization
     * @param array $requestData
     */

    public function createHistory(User $auth, Application $application, $status)
    {
        $applicationHistory = ApplicationStatusHistory::create([
            'user_id' => $auth->id,
            'application_id' => $application->id,
            'new_value' => $status,
            'last_value' => $application->status,
        ]);
    }
}
