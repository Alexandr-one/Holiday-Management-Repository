<?php

namespace App\Http\Controllers\Admin;


use App\Classes\ControlOrganizationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSystemParamsRequest;
use App\Organization;
use App\Repositories\Admin\AdminRepository;
use Illuminate\Support\Facades\Auth;

class AdminPanelController extends Controller
{
    /** @var AdminRepository */
    protected $adminRepository;

    public function __construct(
        AdminRepository $adminRepository
    )
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Получение организации
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $organization = $this->adminRepository->getOrganization();

        return view('admin/panel/index', compact('organization'));
    }

    /**
     * Страница изменения организации
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $organization = $this->adminRepository->getOrganization();
        $users = $this->adminRepository->getAdmins();

        return view('admin/panel/edit/index', compact('organization','users'));
    }

    /**
     * Изменение организации
     *
     * @param UpdateSystemParamsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSystemParamsRequest $request)
    {
        $organization = Organization::find(ControlOrganizationEnum::ID);
        if ($request->get('max_duration_of_vacation') - $request->get('min_duration_of_vacation') <= 0) {
            session()->flash('updateError', 'Отпуск должен быть хотя бы один день');

            return redirect()->route('admin.edit.page');
        } else {
            $this->adminRepository->updateSystem(Auth::user(), $organization, $request->only(['name', 'director_id', 'max_duration_of_vacation', 'min_duration_of_vacation']));
            session()->flash('successUpdating', 'Успешное изменение');
        }


        return redirect()->route('admin.page');
    }
}
