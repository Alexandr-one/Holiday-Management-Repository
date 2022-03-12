<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAccountSettingsRequest;
use App\Http\Requests\UpdateSystemParamsRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\AccountRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountApiController extends Controller
{
    protected $accountRepository;

    public function __construct(
        AccountRepository $accountRepository
    )
    {
        $this->accountRepository = $accountRepository;
    }
    /**
     * update account
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAccountSettingsRequest $request)
    {
        $status = 0;
        $user = User::where('email', $request->get('email'))->first();
        $auth = User::findOrFail($request->get('id'));
        if ($auth != $user) {
            $status = 1;
            session()->put('updateSuccess','Ошибка.Сотрудник с такой почтой найден и это не вы!');
        } else {
            if (Hash::check($request->get('password'), $user->password))
            {
                $this->accountRepository->update($auth, $request->all());
                session()->put('updateSuccess','Изменение прошло успешно');
            } else {
                $status = 2;
                session()->put('updateSuccess','Неверный пароль');
            }
        }

        return $status;
    }
}
