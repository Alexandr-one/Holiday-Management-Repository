<?php

namespace App\Http\Controllers\Api\Application;

use App\Application;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationApiController extends Controller
{
    /**
     * get application using id
     * @param $id
     * @return mixed
     */
    public function getApplication($id)
    {
        return Application::findorfail($id);
    }

    /**
     * get applications
     * @param Request $request
     * @return array
     */
    public function getApplications(Request $request)
    {
        $application = [Application::orderBy('date_start')->where('user_id',$request->get('user_id'))->get(), Application::orderBy('date_finish')->where('user_id',$request->get('user_id'))->get()];

        return $application;
    }
}
