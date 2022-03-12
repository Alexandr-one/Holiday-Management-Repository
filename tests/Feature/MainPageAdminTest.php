<?php

namespace Tests\Feature;

use App\Application;
use App\Classes\UserRolesEnum;
use App\Classes\UserStatusEnum;
use App\Organization;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\Admin\CreatesUser;
use Tests\TestCase;

class MainPageAdminTest extends TestCase
{
    use CreatesUser, RefreshDatabase;

    /**
     * Тест проверки на невозможность зайти на главную страницу админом.
     *
     * @return void
     */
    public function testAccountPage()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $organization = factory(Organization::class)->create();
        $response = $this->get(route('index'));
        $response->assertStatus(302)->assertRedirect(route('index.director'));
        $response = $this->get(route('statistics.director'));
        $response->assertStatus(200);
    }

    /**
     * Тест проверки на невозможность зайти на главную страницу админом.
     *
     * @return void
     */
    public function testAccountAdminPage()
    {
        $user = factory(User::class)->create([
            'role' => UserRolesEnum::EMPLOYEE
        ]);
        Auth::login($user);
        $organization = factory(Organization::class)->create();
        $response = $this->get(route('index.director'));
        $response->assertStatus(302)->assertRedirect(route('index'));
        $response = $this->get(route('statistics'));
        $response->assertStatus(200);
    }

    /**
     * Удаление заявок
     *
     * @return void
     */
    public function testDeleteApplication()
    {
        $user = factory(User::class)->create([
            'status' => UserStatusEnum::ACTIVE,
        ]);
        $application = factory(Application::class)->create([
           'user_id' => $user->id
        ]);
        Auth::login($user);
        $response = $this->post(route('delete.application'),[
            'id' => $application->id,
        ]);
        $response->assertStatus(302)->assertSessionHas('ErrorDate');
    }

    /**
     * Изменение заявки
     *
     * @return void
     */
    public function testUpdateApplication()
    {
        $user = factory(User::class)->create([
            'status' => UserStatusEnum::ACTIVE,
        ]);
        $application = factory(Application::class)->create([
            'user_id' => $user->id
        ]);
        $organization = factory(Organization::class)->create();
        Auth::login($user);
        $response = $this->post(route('update.application'),[
            'id' => $application->id,
            'date_start' => '2022-03-14',
            'date_finish' => '2022-03-12',
        ]);
        $response->assertStatus(302)->assertSessionHas('ErrorDate');
    }


}
