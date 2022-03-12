<?php

namespace App\Http\Controllers;

use App\Classes\UserStatusEnum;
use App\Http\Requests\ChangeAccountPasswordRequest;
use App\Repositories\AccountRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * @var AccountRepository
     */
    protected $accountRepository;

    /**
     * @param AccountRepository $accountRepository
     */
    public function __construct(
        AccountRepository $accountRepository
    )
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * Страница с личными данными пользователя
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->fio != null && $user->fio_parent_case != null && $user->address != null) {
            $user->status = UserStatusEnum::ACTIVE;
            $user->save();
        } else {
            $user->status = UserStatusEnum::WAITING;
            $user->save();
        }

        return view('account/index',compact('user'));
    }

    /**
     * Изменение пароля
     *
     * @param ChangeAccountPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(ChangeAccountPasswordRequest $request)
    {
        $user = Auth::user();
        if (Hash::check($request->get('password'), $user->password)) {
            $user->password = Hash::make($request->get('new_password'));
            $user->save();
            Auth::logout();
        } else {
            session()->flash('updateErrors','Неверный пароль');

            return redirect()->route('account');
        }

        return redirect()->route('login');
    }
}
