<?php

namespace App\Http\Controllers\Admin\History;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\History\SystemHistoryRepository;
use App\SystemHistory;

class SystemHistoryController extends Controller
{
    /** @var SystemHistoryRepository */
    protected $userHistoryRepository;

    /**
     * @param SystemHistoryRepository $systemHistoryRepository
     */
    public function __construct(
        SystemHistoryRepository $systemHistoryRepository
    )
    {
        $this->systemHistoryRepository = $systemHistoryRepository;
    }

    /**
     * Получение истории
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function systemHistory()
    {
        $systemHistories =  $this->systemHistoryRepository->getSystemHistory();

        return view('admin/histories/system/index', compact('systemHistories'));
    }

    /**
     * Очистка истории
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearSystemHistory()
    {
        SystemHistory::truncate();

        return redirect()->back();
    }
}
