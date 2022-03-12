<?php

namespace App\Http\Controllers;

use App\Application;
use App\Classes\ApplicationStatusEnum;
use App\Http\Services\MailService;
use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\History\ApplicationStatusHistoryRepository;
use App\Repositories\DirectorRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DirectorController extends Controller
{
    /**
     * @var ApplicationStatusHistoryRepository
     */
    protected $applicationStatusHistoryRepository;
    protected $mailService;
    protected $adminRepository;
    protected $directorRepository;

    /**
     * @param ApplicationStatusHistoryRepository $applicationStatusHistoryRepository
     * @param MailService $mailService
     * @param AdminRepository $adminRepository
     */
    public function __construct(
        ApplicationStatusHistoryRepository $applicationStatusHistoryRepository,
        MailService $mailService,
        AdminRepository $adminRepository,
        DirectorRepository $directorRepository
    )
    {
        $this->applicationStatusHistoryRepository = $applicationStatusHistoryRepository;
        $this->mailService = $mailService;
        $this->adminRepository = $adminRepository;
        $this->directorRepository = $directorRepository;
    }

    /**
     * Отображение всех заявок
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $getUser = '';
        $getStatus = '';
        $applications = Application::query();
        $users = User::all();
        if ($user_id = $request->get('user_id')) {
            $applications->where('user_id',$user_id);
            $getUser = User::findOrFail($user_id);
        }
        if ($status = $request->get('status')) {
            $applications->where('status',$status);
            $getStatus = $status;
        }
        $applications = $applications->paginate(10);
        return view('director/index',compact('applications','users','getStatus','getUser'));
    }

    /**
     * Отклонение заявки
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function refuseApplication(Request $request)
    {
        $application = Application::findOrFail($request->get('id'));
        $this->applicationStatusHistoryRepository->createHistory(Auth::user(),$application,ApplicationStatusEnum::REFUSED );
        $application->status = ApplicationStatusEnum::REFUSED;
        $application->save();
        $posts = "Ваша заявка не утверждена.";
        $email = $application->users->email;
        $name = "Holiday Management System";
        $title = "Действия по заявке на отпуск";
        $this->mailService->sendMail($posts,$email,$name, $title);

        return redirect()->back();
    }

    /**
     * Подтверждение заявок
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmApplication(Request $request)
    {
        $application = Application::findOrFail($request->get('id'));
        $numOfDays = 0;
        $organization = $this->adminRepository->getOrganization();
        $applications = Application::where('user_id',$application->users->id)->where('status',ApplicationStatusEnum::CONFIRMED)->get();
        foreach ($applications as $item){
            if(substr($application->date_start,0,4) == substr($item->date_start,0,4))
            {
                $numOfDays += $item['number_of_days'];
            }
        }
        if ($numOfDays + $application->number_of_days > $organization->max_duration_of_vacation) {
            session()->flash('ErrorConfirmation','Ошибка! Подтвердить данную заявку нельзя, так как пользователь привысит максимальное количество дней отпуска('.$organization->max_duration_of_vacation.' дней) в году.');
        } else {
            $this->applicationStatusHistoryRepository->createHistory(Auth::user(),$application,ApplicationStatusEnum::CONFIRMED );
            $application->status = ApplicationStatusEnum::CONFIRMED;
            $application->save();
            $posts = "Ваша заявка утверждена.";
            $email = $application->users->email;
            $name = "Holiday Management System";
            $title = "Действия по заявке на отпуск";
            $this->mailService->sendMail($posts,$email,$name, $title);
        }

        return redirect()->back();
    }

    /**
     * Отображение статистики
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function statistics(Request $request)
    {
        $applications = Application::query()->where('status',ApplicationStatusEnum::CONFIRMED)->get();
        $organization = $this->adminRepository->getOrganization();
        $users = User::all();
        $groupByDate = [];
        $finishGroupMass = [];
        $getUser = '';
        $getStatus = '';
        if ($user_id = $request->get('user_id')) {
            $applications = $applications->where('user_id',$user_id);
        }
        foreach ($applications as $application) {
            $years = Carbon::createFromFormat('Y-m-d', $application->date_start)->year;
            $finishGroupMass[$years][] = $application;
        }
        if ($year = $request->get('year')) {
            if (array_key_exists($year, $finishGroupMass)) {
                $groupByDate[$year] = $finishGroupMass[$year];
            }
        } else {
            $groupByDate = $finishGroupMass;
        }

        return view('director/statistics/index', compact('groupByDate','getStatus','getUser','users','organization'));
    }
}
