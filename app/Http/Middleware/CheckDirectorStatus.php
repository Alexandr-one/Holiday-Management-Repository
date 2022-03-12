<?php

namespace App\Http\Middleware;

use App\Classes\UserRolesEnum;
use App\Classes\UserStatusEnum;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckDirectorStatus
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
        if(Auth::user()->role == UserRolesEnum::ADMIN) {
            return redirect($request->getUri().'director');
        }
        return $next($request);
    }
}
