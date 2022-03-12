<?php

namespace App\Http\Middleware;

use App\Classes\UserRolesEnum;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckEmployeeStatus
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
        if(Auth::user()->role == UserRolesEnum::EMPLOYEE) {
            return redirect(route('index'));
        }
        return $next($request);
    }
}
