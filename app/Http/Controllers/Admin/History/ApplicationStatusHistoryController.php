<?php

namespace App\Http\Controllers\Admin\History;

use App\ApplicationStatusHistory;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\History\ApplicationStatusHistoryRepository;

class ApplicationStatusHistoryController extends Controller
{
    /** @var ApplicationStatusHistoryRepository */
    protected $applicationStatusHistoryRepository;

    /**
     * @param ApplicationStatusHistoryRepository $applicationStatusHistoryRepository
     */
    public function __construct(
        ApplicationStatusHistoryRepository $applicationStatusHistoryRepository
    )
    {
        $this->applicationStatusHistoryRepository = $applicationStatusHistoryRepository;
    }

    /**
     * Получение истории
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function applicationStatusHistory()
    {
        $applicationStatusHistories = $this->applicationStatusHistoryRepository->getApplicationStatusHistory();

        return view('admin/histories/application/status/index',compact('applicationStatusHistories'));
    }

    /**
     * Очистка истории
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearApplicationStatusHistory()
    {
        ApplicationStatusHistory::truncate();

        return redirect()->back();
    }
}
