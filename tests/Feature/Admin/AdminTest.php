<?php

namespace Tests\Feature\Admin;

use App\Classes\UserRolesEnum;
use App\Classes\UserStatusEnum;
use App\Organization;
use App\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use CreatesUser, RefreshDatabase;
    /**
     * Тест проверки на возможность зайти на страницу admin.
     *
     * @return void
     */
    public function testAdminPage()
    {
        $response = $this->get(route('admin.page'));

        $response->assertStatus(302);
    }

    /**
     * Проверка на то, что авторизованный сотрудник не может зайти в систему
     *
     * @return void
     */
    public function testAuthUserAdminPage()
    {
        $position = factory(Position::class)->create([
            'name' => 'name'
        ]);
        $user = factory(\App\User::class)->create([
            'position_id' => $position->id,
            'role' => UserRolesEnum::EMPLOYEE,
        ]);

        Auth::login($user);

        $response = $this->get(route('admin.page'));

        $response->assertStatus(302);
    }

    /**
     * Проверка посещение главной страницы админки руководителем
     *
     * @return void
     */
    public function testAuthUserAdmin()
    {
        $position = factory(Position::class)->create([
            'name' => 'name'
        ]);
        $user = factory(\App\User::class)->create([
            'password' => password_hash($this->faker->word, PASSWORD_BCRYPT),
            'status' => UserStatusEnum::ACTIVE,
            'role' => UserRolesEnum::ADMIN,
            'position_id' => $position->id
        ]);
        Auth::login($user);
        $organization = factory(Organization::class)->create([
            'director_id' => $user->id,
        ]);
        $response = $this->get(route('admin.page'));

        $response->assertStatus(200);
    }

    /**
     * Проверка перехода на страницу изменения параметров системы
     *
     * @return void
     */
    public function testAdminEditPage()
    {
        $position = factory(Position::class)->create([
            'name' => 'name'
        ]);
        $user = factory(\App\User::class)->create([
            'password' => password_hash($this->faker->word, PASSWORD_BCRYPT),
            'role' => UserRolesEnum::ADMIN,
            'status' => UserStatusEnum::ACTIVE,
            'position_id' => $position->id
        ]);
        Auth::login($user);
        $organization = factory(Organization::class)->create([
            'director_id' => $user->id,
        ]);
        $response = $this->get(route('admin.edit.page'));

        $response->assertStatus(200);
    }

    /**
     *Изменение параметров системы
     *
     * @return void
     */
    public function testUpdateSystem()
    {
        $position = factory(Position::class)->create([
            'name' => 'name'
        ]);
        $user = factory(\App\User::class)->create([
            'password' => password_hash($this->faker->word, PASSWORD_BCRYPT),
            'role' => UserRolesEnum::ADMIN,
            'status' => UserStatusEnum::ACTIVE,
            'position_id' => $position->id
        ]);
        Auth::login($user);
        $organization = factory(Organization::class)->create([
            'director_id' => $user->id,
        ]);
        $response = $this->post(route('admin.update'), [
            'name' => 'test',
            'director_id' => 1,
            'max_duration_of_vacation' => 60,
            'min_duration_of_vacation' => 24
        ]);

        $response->assertStatus(302)->assertRedirect(route('admin.page'));
        $response->assertSessionHas('successUpdating', function ($value) use ($user) {
            return $value === 'Успешное изменение';
        });
    }

    /**
     *Изменение параметров системы
     *
     * @return void
     */
    public function testUpdateSystemNullDuration()
    {
        $position = factory(Position::class)->create([
            'name' => 'name'
        ]);
        $user = factory(\App\User::class)->create([
            'password' => password_hash($this->faker->word, PASSWORD_BCRYPT),
            'role' => UserRolesEnum::ADMIN,
            'status' => UserStatusEnum::ACTIVE,
            'position_id' => $position->id
        ]);
        Auth::login($user);
        $organization = factory(Organization::class)->create([
            'director_id' => $user->id,
        ]);
        $response = $this->post(route('admin.update'), [
            'name' => 'test',
            'director_id' => 1,
            'max_duration_of_vacation' => 24,
            'min_duration_of_vacation' => 60
        ]);

        $response->assertStatus(302)->assertRedirect(route('admin.edit.page'));
        $response->assertSessionHas('updateError', function ($value) use ($user) {
            return $value === 'Отпуск должен быть хотя бы один день';
        });
    }

    /**
     * Проверка валидации при изменении параметров системы
     *
     * @return void
     */
    public function testUpdateSystemValidate()
    {
        $position = factory(Position::class)->create([
            'name' => 'name'
        ]);
        $user = factory(\App\User::class)->create([
            'password' => password_hash($this->faker->word, PASSWORD_BCRYPT),
            'role' => UserRolesEnum::ADMIN,
            'status' => UserStatusEnum::ACTIVE,
            'position_id' => $position->id
        ]);
        $this->post(route('admin.update'), [
            'name' => 'name',
            'director_id' => $user->id
        ])->assertSessionMissing(['max_duration_of_vacation','min_duration_of_vacation']);
    }
}
