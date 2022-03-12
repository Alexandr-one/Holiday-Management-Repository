<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Position;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    /**
     * @param $id
     * @return mixed
     */
    public function getPost($id)
    {
        return  Position::findorfail($id);
    }
}
