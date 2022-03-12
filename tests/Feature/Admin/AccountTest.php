<?php

namespace Tests\Feature\Admin;

use App\Classes\ControlOrganizationEnum;
use App\Classes\UserStatusEnum;
use App\Organization;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use CreatesUser, RefreshDatabase;

    /**
     * Тест проверки на невозможность зайти на страницу аккаунта.
     *
     * @return void
     */
    public function testAccountPage()
    {
        $response = $this->get(route('account'));
        $response->assertStatus(302)->assertRedirect(route('login'));
    }

    /**
     * Тест проверки на возможность зайти на страницу аккаунта.
     *
     * @return void
     */
    public function testAccountAuthPage()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $organization = factory(Organization::class)->create();
        $response = $this->get(route('account'));
        $response->assertStatus(200);
    }

    /**
     * Тест проверки на выход.
     *
     * @return void
     */
    public function testLogout()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $response = $this->post(route('logout'));
        $response->assertStatus(302)->assertRedirect('login');
    }

    /**
     * Тест проверки изменения пароля пользователя.
     *
     * @return void
     */
    public function testAccountPasswordUpdateIncorrectPassword()
    {
        $user = factory(User::class)->create([
            'status' => UserStatusEnum::ACTIVE,
        ]);
        Auth::login($user);
        $response = $this->post(route('change.account.password'),[
            'password' => '123123123123',
            'new_password' => 'asdasdasd',
        ]);
        $response->assertStatus(302)->assertRedirect(route('account'));
    }

    /**
     * Тест проверки изменения пароля пользователя.
     *
     * @return void
     */
    public function testAccountPasswordUpdate()
    {
        $user = factory(User::class)->create([
            'status' => UserStatusEnum::ACTIVE,
        ]);
        Auth::login($user);
        $response = $this->post(route('change.account.password'),[
            'password' => '123123123',
            'new_password' => '21312312123',
        ]);
        $response->assertStatus(302)->assertRedirect(route('login'));
    }
}
