<?php

namespace App\Repositories\Admin;

use App\Classes\ControlOrganizationEnum;
use App\Classes\UserRolesEnum;
use App\Organization;
use App\Repositories\Admin\History\SystemHistoryRepository;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class AdminRepository
{
    /** @var SystemHistoryRepository */
    protected $systemHistoryRepository;

    public function __construct(
        SystemHistoryRepository $systemHistoryRepository
    )
    {
        $this->systemHistoryRepository = $systemHistoryRepository;
    }

    /**
     * Получение огранизации
     *
     * @return mixed
     */
    public function getOrganization()
    {
        return Organization::find(ControlOrganizationEnum::ID);
    }

    /**
     * Получение админов
     *
     * @return mixed
     */
    public function getAdmins()
    {
        return User::where('role', UserRolesEnum::ADMIN)->get();
    }

    /**
     * Изменение параметров системы
     *
     * @param User $user
     * @param Organization $organization
     * @param array $requestData
     * @return Organization
     */
    public function updateSystem(User $user, Organization $organization, array $requestData = []): Organization
    {
        $this->systemHistoryRepository->createHistory($user, $organization, $requestData);

        $organization->fill($requestData);
        $organization->save();
        Log::info('[AdminRepository] Update System');

        return $organization;
    }
}
