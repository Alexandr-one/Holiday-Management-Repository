<?php

namespace Tests\Feature\Admin;

use App\Classes\UserRolesEnum;
use App\Classes\UserStatusEnum;
use App\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserTest extends TestCase
{
    use CreatesUser, RefreshDatabase;
    /**
     * Посещение страницы пользователей админом.
     *
     * @return void
     */
    public function testVisitAdminUsersPage()
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

        $response = $this->get(route('admin.users.page'));

        $response->assertStatus(200);
    }

    /**
     * Посещение страницы пользователей пользователем с незаполненными данными
     *
     * @return void
     */
    public function testVisitWaitingUserPositionPage()
    {
        $position = factory(Position::class)->create([
            'name' => 'name'
        ]);
        $user = factory(\App\User::class)->create([
            'password' => password_hash($this->faker->word, PASSWORD_BCRYPT),
            'status' => UserStatusEnum::WAITING,
            'role' => UserRolesEnum::ADMIN,
            'position_id' => $position->id
        ]);
        Auth::login($user);
        $response = $this->get(route('admin.posts.page'));

        $response->assertStatus(302)->assertRedirect('account');
    }

    /**
     * Посещение страницы изменения пользователя
     *
     * @return void
     */
    public function testVisitUserEditPage()
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
        $userUpdated = factory(\App\User::class)->create([
            'password' => password_hash($this->faker->word, PASSWORD_BCRYPT),
            'status' => UserStatusEnum::ACTIVE,
            'role' => UserRolesEnum::EMPLOYEE,
            'position_id' => $position->id
        ]);
        Auth::login($user);
        $response = $this->get('admin/users/edit/'.$userUpdated->id);

        $response->assertStatus(200);
    }

    public function testBlockUser()
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
        $response = $this->post(route('block.user'), [
            'block_reason' => 'test',
            'user_id' => $user->id,
        ]);

        $response->assertStatus(302);
    }
}

