<?php

namespace App\Http\Controllers;

use App\Application;
use App\Classes\ApplicationStatusEnum;
use App\Classes\ControlOrganizationEnum;
use App\Http\Requests\AddAplicationRequest;
use App\Http\Requests\DeleteApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Organization;
use App\Repositories\ApplicationRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApplicationController extends Controller
{
    protected $applicationRepository;

    public function __construct(
        ApplicationRepository $applicationRepository
    )
    {
        $this->applicationRepository = $applicationRepository;
    }

    /**
     * Получение заявок
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $applications = $this->applicationRepository->index(Auth::user());

        return view('welcome',compact('applications'));
    }

    /**
     * Удаление заявок
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteApplication(DeleteApplicationRequest $request)
    {
        $application = $this->applicationRepository->deleteApplication($request->only('id'));
        if ($application->status == ApplicationStatusEnum::WAITING) {
            $application->delete();
        } else {
            session()->flash('ErrorDate','Ошибка! Удалять можно заявки только со статусом: "Ожидает подтверждения"!');
        }
        return redirect()->route('index');
    }

    /**
     * Выход
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    /**
     * Добавление заявки
     *
     * @param AddAplicationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addApplication(AddAplicationRequest $request)
    {
        $organizationDays = Organization::findorfail(ControlOrganizationEnum::ID);
        $date1 = Carbon::createFromFormat('Y-m-d', $request->get('date_start'));
        $date2 = Carbon::createFromFormat('Y-m-d', $request->get('date_finish'));

        $diff = $date1->diffInDays($date2,false) + 1;

        if (Carbon::now() >= $date1 ) {
            session()->flash('ErrorDate','Ошибка! Введите начальную дату, которая будет!');
        }
        else if ($diff <= 0) {
            session()->flash('ErrorDate','Ошибка! Отпуск не может быть меньше одного дня');
        }
        else if ($organizationDays->max_duration_of_vacation < $diff) {
            session()->flash('ErrorDate','Ошибка! Введенный вами промежуток('.$diff .' дней) больше положенного('.$organizationDays->max_duration_of_vacation.' дней)');
        } else {
            $this->applicationRepository->addApplication(Auth::user(),$date1,$date2,$request->only('comment'),$diff);
        }

        return redirect()->back();
    }

    /**
     * Печать документа
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function download(Request $request)
    {
        $organization = Organization::findOrFail(ControlOrganizationEnum::ID);
        $user = Auth::user();
        $application = Application::findOrFail($request->get('id'));

//        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', compact('organization','user','application'));
//
//        return $pdf->download('invoice.pdf');

        return view('pdf/invoice',compact('organization','user','application'));
    }

    /**
     * Изменение заявки
     *
     * @param AddAplicationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateApplication(UpdateApplicationRequest $request)
    {
        $organizationDays = Organization::findorfail(ControlOrganizationEnum::ID);
        $date1 = Carbon::createFromFormat('Y-m-d', $request->get('date_start'));
        $date2 = Carbon::createFromFormat('Y-m-d', $request->get('date_finish'));
        $application = Application::findorfail($request->get('id'));
        $diff = $date1->diffInDays($date2,false) + 1;
        if (Carbon::now() >= $date1 ) {
            session()->flash('ErrorDate','Ошибка! Введите начальную дату, которая будет!');
        }
        else if ($diff <= 0) {
            session()->flash('ErrorDate','Ошибка! Отпуск не может быть меньше одного дня');
        }
        else if ($organizationDays->max_duration_of_vacation < $diff) {
            session()->flash('ErrorDate','Ошибка! Введенный вами промежуток('.$diff .' дней) больше положенного('.$organizationDays->max_duration_of_vacation.' дней)');
        }
        else if ($application->status == ApplicationStatusEnum::CONFIRMED) {
            session()->flash('ErrorDate','Ошибка! Нельзя редактировать заявки у которых статус: "Подтверждена"');
        }
        else if ($application) {
            $this->applicationRepository->updateApplication($application,$date1,$date2,$request->get('comment'),$diff);
        }

        return redirect()->back();
    }

}
