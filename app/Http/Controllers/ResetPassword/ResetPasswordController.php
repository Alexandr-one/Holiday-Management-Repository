<?php

namespace App\Http\Controllers\ResetPassword;

use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendEmailMessRequest;
use App\Repositories\AuthRepository;
use App\Repositories\ResetPasswordRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController
{
    /** @var ResetPasswordRepository  */
    protected $resetPasswordRepository;

    public function __construct(
        ResetPasswordRepository $resetPasswordRepository
    )
    {
        $this->resetPasswordRepository = $resetPasswordRepository;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view("auth.forget_password.index");
    }

    /**
     * @param SendEmailMessRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendEmailToReset(SendEmailMessRequest $request)
    {
        $send = $this->resetPasswordRepository->sendCode($request->only('email'), $error);
        if (!$send) {
            session()->flash('noneUser', $error);

            return redirect()->back();
        }

        return redirect(route('password.change.page'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function passwordChangePage()
    {
        return view('auth/forget_password/reset_password/index');
    }

    /**
     * @param ResetPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function passwordChange(ResetPasswordRequest $request)
    {
        $userStatus = $this->resetPasswordRepository->change($request->only(['password','code']));
        if (!$userStatus) {
            session()->flash('errorCode', 'Неверный код');

            return redirect()->back();
        }
        else {
            session()->put('successResetPassword', 'Ваш пароль успешно изменен');
        }

        return redirect()->route('login');
    }
}
