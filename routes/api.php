<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/application/{id}', 'Api\Application\ApplicationApiController@getApplication');
Route::get('/application', 'Api\Application\ApplicationApiController@getApplications');
Route::post('/account/update', 'Api\AccountApiController@update');
Route::get('/admin/post/{id}', 'Api\Admin\PostApiController@getPost');
Route::get('/admin/user/{id}', 'Api\Admin\UsersApiController@getUser');
