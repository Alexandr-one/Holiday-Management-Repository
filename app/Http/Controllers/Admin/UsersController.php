<?php

namespace App\Http\Controllers\Admin;

use App\Classes\UserRolesEnum;
use App\Classes\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlockUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserPostRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Position;
use App\Repositories\Admin\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    /** @var UserRepository */
    protected $systemHistoryRepository;

    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Получение пользователей
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = $this->userRepository->showUsers();
        $posts = $this->userRepository->showPosts();

        return view('admin/users/index', compact('users', 'posts'));
    }

    /**
     * Добавление пользователя
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createUser(CreateUserRequest $request)
    {
        $user = $this->userRepository->createUser($request->all());
        if ($user) {
            session()->flash('successCreate', 'Пользователь '.$request->get('email').' добавлен');
        } else {
            session()->flash('createError', 'Пользователь с такой почтой уже сущестует');
        }

        return redirect()->back();
    }

    /**
     * Изменение статуса
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(UpdateStatusRequest $request)
    {
        $admin = User::where('role',UserRolesEnum::ADMIN)->count();
        $user = User::findorfail($request->get('id'));
        if ($user) {
            if ($user->role == UserRolesEnum::ADMIN && $admin == 1 && $request->get('status') != UserRolesEnum::ADMIN) {
                session()->flash('updateStatusError', 'Ошибка. Нельзя, чтобы в системе не было руководителя');
            } else {
                $user->role = $request->get('status');
                $user->save();
                session()->flash('updateStatusSuccess','Статус пользователя изменен');
            }
        }

        return redirect()->back();
    }

    /**
     * @param BlockUserRequest $request
     * Блокировка пользователя
     * @return \Illuminate\Http\RedirectResponse
     */
    public function blockUser(BlockUserRequest $request)
    {
        $user = $this->userRepository->blockUser($request->all());
        if ($user) {
            session()->flash('updateStatusSuccess','Пользователь заблокирован');
        } else {
            session()->flash('updateStatusError', 'Ошибка. Нельзя, чтобы в системе единственный руководитель был заблокирован');
        }

        return redirect()->back();
    }

    /**
     * Страница изменения пользователя
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editUser($id)
    {
        $user = User::findorfail($id);

        return view('admin/users/edit/index', compact('user'));
    }

    public function update(UpdateUserRequest $request)
    {
        $user = User::where('email',$request->get('email'))->first();
        $userSec = User::findOrFail($request->get('id'));
        if($user && $user->id != $userSec->id) {
            session()->flash('updateError','Пользователь с такой почтой найден и это не вы!');

            return redirect()->back();
        } else {
            $this->userRepository->updateUser(Auth::user(),$request->only('id','fio','fio_parent_case','address','email'));
        }

        return redirect()->route('admin.users.page');
    }

    public function deleteUser(Request $request)
    {
        $adminCount = User::where('role', UserRolesEnum::ADMIN)->count();
        $user = User::findorfail($request->get('user_id'));
        if ($user->role === UserRolesEnum::ADMIN &&
            $adminCount === 1){
            session()->flash('updateStatusError', 'Ошибка. Нельзя, чтобы в системе единственный руководитель был удален');
         } else {
            $user->delete();
            session()->flash('updateStatusSuccess','Пользователь '.$user->email.' удален');

        }


        return redirect()->back();
    }

    /**
     * unblocking the user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unblockUser(Request $request)
    {
        $user = $this->userRepository->unblockUser($request->all());
        if($user)
        {
            session()->flash('updateStatusSuccess','Пользователь разблокирован');
        }

        return redirect()->back();
    }

    /**
     * Updating users post
     * @param UpdateUserPostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePost(UpdateUserPostRequest $request)
    {
        $user = $this->userRepository->updatePost(Auth::user(), $request->only(['position_id','user_id']));
        if($user){
            session()->flash('updateStatusSuccess','Должность пользователя изменена');
        }

        return redirect()->back();

    }

}
