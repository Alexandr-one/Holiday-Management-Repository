<?php

namespace App\Http\Middleware;

use App\Classes\UserStatusEnum;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckWaitingUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->status == UserStatusEnum::WAITING) {
            session()->put('waitingMessage','Сотруднику запрещена работа с системой без данных. Заполните форму');
            return redirect()->route('account');
        }

        return $next($request);
    }
}
