<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Repositories\AuthRepository;

class AuthController extends Controller
{
    /** @var AuthRepository  */
    protected $authRepository;

    public function __construct(
        AuthRepository $authRepository
    )
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Страница авторизации
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view("auth.login.index");
    }

    /**
     * Авторизация
     *
     * @param AuthRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(AuthRequest $request)
    {
        $this->authRepository->login($request->only(['email','password']), $error);

        session()->put('emailReset', $request->get('email'));

        if ($error) {
            session()->flash('loginErrors', $error);
            return redirect()->back();
        }

        return redirect()->route('index');
    }
}
