<?php

namespace App\Http\Controllers;

use App\Application;
use App\Classes\ApplicationStatusEnum;
use App\Classes\ControlOrganizationEnum;
use App\Classes\UserStatusEnum;
use App\Organization;
use App\Repositories\Admin\AdminRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PersonalStatisticsController extends Controller
{
    protected $adminRepository;

    public function __construct(
        AdminRepository $adminRepository
    )
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Отображение статистики
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $applications = Application::where('user_id', Auth::id())->where('status',ApplicationStatusEnum::CONFIRMED)->get();
        $groupByDate = [];
        $organization = $this->adminRepository->getOrganization();
        foreach ($applications as $application) {
            $years = Carbon::createFromFormat('Y-m-d', $application->date_start)->year;
            $groupByDate[$years][] = $application;
        }

        return view('account/statistics/index', compact('groupByDate','organization'));
    }
}
