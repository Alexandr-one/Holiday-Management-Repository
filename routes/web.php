<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Проверка на то что пользователь не авторизован
Route::middleware(['auth.block'])->group(function () {
    // Страница авторизации
    Route::get('/login', 'AuthController@index')->name('login.page');
    // Сброс паролей
    Route::get('/password/reset','ResetPassword\ResetPasswordController@index')->name('password.reset');
    // Смена паролей
    Route::get('/password/change','ResetPassword\ResetPasswordController@passwordChangePage')->name('password.change.page');
});

// Авторизация
Route::post('/login', 'AuthController@login')->name('login');
// отправка на email сообщения с кодом
Route::post('password/reset/email','ResetPassword\ResetPasswordController@sendEmailToReset')->name('password.reset.email');
// воостановление и изменение пароля
Route::post('/password/change', 'ResetPassword\ResetPasswordController@passwordChange')->name('password.change');

//Проверка на то, что пользователь является админом с заполненными данными
Route::middleware(['admin','waiting.status'])->prefix('admin')->group(function (){
    //История пользователей
    Route::get('/history/users', 'Admin\History\UserHistoryController@usersHistory')->name('users.history');
    Route::post('/history/users/clear', 'Admin\History\UserHistoryController@clearUsersHistory')->name('clear.users.history');
    //История изменения параметров систем
    Route::get('/history/system', 'Admin\History\SystemHistoryController@systemHistory')->name('system.history');
    Route::post('/history/system/clear', 'Admin\History\SystemHistoryController@clearSystemHistory')->name('clear.system.history');
    //История изменения статусов заявок
    Route::get('/history/application_status', 'Admin\History\ApplicationStatusHistoryController@applicationStatusHistory')->name('application.status.history');
    Route::post('/history/application_status/clear', 'Admin\History\ApplicationStatusHistoryController@clearApplicationStatusHistory')->name('clear.application.status.history');
    //Главная страница admin
    Route::get('/', 'Admin\AdminPanelController@index')->name('admin.page');
    //Страница изменения параметров системы
    Route::get('/edit', 'Admin\AdminPanelController@edit')->name('admin.edit.page');
    //Изменение параметров системы
    Route::post('/update', 'Admin\AdminPanelController@update')->name('admin.update');
    //Страница пользователей
    Route::get('/users', 'Admin\UsersController@index')->name('admin.users.page');
    //Страница изменения пользователя
    Route::get('/users/edit/{id}', 'Admin\UsersController@editUser')->name('user.edit');
    //Блокировка пользователя
    Route::post('/users/block', 'Admin\UsersController@blockUser')->name('block.user');
    //Удаление пользователей
    Route::post('/users/delete', 'Admin\UsersController@deleteUser')->name('delete_user');
    //Добавление пользователя
    Route::post('/users/add', 'Admin\UsersController@createUser')->name('add.user');
    //Разблокировка пользователей
    Route::post('/users/unblock', 'Admin\UsersController@unblockUser')->name('unblock.user');
    //Изменение должности
    Route::post('/users/update/post', 'Admin\UsersController@updatePost')->name('update.user.post');
    //Изменение статуса
    Route::post('/users/update/status', 'Admin\UsersController@updateStatus')->name('update_status');
    //Изменение пользователей
    Route::post('/users/update','Admin\UsersController@update')->name('user_update');
    //Получение должности
    Route::get('/posts', 'Admin\PostController@index')->name('admin.posts.page');
    //Добавление должности
    Route::post('/posts/add', 'Admin\PostController@addPosition')->name('add.post');
    //Изменение должности
    Route::post('/posts/update', 'Admin\PostController@updatePosition')->name('update.post');
    //Удаление должности
    Route::post('/posts/delete', 'Admin\PostController@deletePosition')->name('delete.post');
});

//Пользователь авторизован, у него заполнены данные и он не админ
Route::middleware(['auth','waiting.status','dashboard.director.status'])->group(function (){
    //Главная страница сотрудника
    Route::get('/', 'ApplicationController@index')->name('index');
    //Получение версии печати
    Route::get('invoices/download', 'ApplicationController@download')->name('pdf');
    //Страница статистики сотрудника
    Route::get('/statistics/', 'PersonalStatisticsController@index')->name('statistics');
});

//Пользователь авторизован, у него заполнены данные
Route::middleware(['auth','waiting.status'])->group(function (){
    //Добавление заявки
    Route::post('/application/add', 'ApplicationController@addApplication')->name('add.application');
    //Изменение заявки
    Route::post('/application/update', 'ApplicationController@updateApplication')->name('update.application');
    //Удаление заявки
    Route::post('/application/delete', 'ApplicationController@deleteApplication')->name('delete.application');
});

//Пользователь авторизован, у него заполнены данные и он админ
Route::middleware(['auth','waiting.status','dashboard.employee.status'])->group(function (){
    //Главная страница администратора
    Route::get('/director', 'DirectorController@index')->name('index.director');
    //Утверждение заявки
    Route::post('/application/confirm', 'DirectorController@confirmApplication')->name('confirm.application');
    //Отклонение заявки
    Route::post('/application/refuse', 'DirectorController@refuseApplication')->name('refuse.application');
    //Страница статистики сотрудников
    Route::get('/statisticsdirector', 'DirectorController@statistics')->name('statistics.director');
});

//Проверка на авторизованного пользователя
Route::middleware(['auth'])->group(function (){
    //Станица пользователя,где можно изменить личные данные и пароль
    Route::get('/account', 'AccountController@index')->name('account');
    //Выход
    Route::post('/logout', 'ApplicationController@logout')->name('logout');
    //Изменение пароля
    Route::post('/account/change/password','AccountController@changePassword')->name('change.account.password');
});

