<?php

namespace App\Http\Controllers\Admin\History;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\History\UserHistoryRepository;
use App\UserHistory;
use Illuminate\Http\Request;

class UserHistoryController extends Controller
{
    /** @var UserHistoryRepository */
    protected $userHistoryRepository;

    /**
     * @param UserHistoryRepository $userHistoryRepository
     */
    public function __construct(
        UserHistoryRepository $userHistoryRepository
    )
    {
        $this->userHistoryRepository = $userHistoryRepository;
    }

    /**
     * Получение истории
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function usersHistory(Request $request)
    {
        $usersHistory = $this->userHistoryRepository->getUsersHistories($request->only('user_id'));

        return view('admin/histories/users/index', compact('usersHistory'));
    }

    /**
     * Очистка истории
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearUsersHistory()
    {
        UserHistory::truncate();

        return redirect()->back();
    }

}
