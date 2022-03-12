<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Position;
use Illuminate\Http\Request;

class UsersApiController extends Controller
{
    public function getUser($id)
    {
        $user = Position::findorfail($id);

        return $user;
    }
}
