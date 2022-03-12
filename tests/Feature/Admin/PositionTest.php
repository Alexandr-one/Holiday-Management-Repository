<?php

namespace Tests\Feature\Admin;

use App\Classes\UserRolesEnum;
use App\Classes\UserStatusEnum;
use App\Organization;
use App\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PositionTest extends TestCase
{
    use CreatesUser, RefreshDatabase;
    /**
     * Посещение страницы должностей админом.
     *
     * @return void
     */
    public function testVisitAdminPositionPage()
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

        $response = $this->get(route('admin.posts.page'));

        $response->assertStatus(200);
    }

    /**
     * Получение должности пользователем с незаполненными данными
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

        $response->assertStatus(302);
    }

    /**
     *
     * Добавление должности
     *
     * @return void
     */
    public function testAddPosition()
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
        $response = $this->post(route('add.post'), [
            'name' => "asdasd",
            'name_parent_case' => "asd"
        ]);

        $response->assertStatus(302);
    }

    /**
     * Добавление должности без передачи параметров
     *
     * @return void
     */
    public function testAddPositionValidate()
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
        $response = $this->post(route('add.post'), [
        ]);
        $response->assertSessionMissing(['name','name_parent_case']);
        $response->assertStatus(302);
    }

    /**
     * Изменение должности без передачи параметров
     *
     * @return void
     */
    public function testUpdatePositionValidate()
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
        $response = $this->post(route('update.post'), [
        ]);
        $response->assertSessionMissing(['name','name_parent_case']);
        $response->assertStatus(302);
    }

    /**
     * Изменение должности
     *
     * @return void
     */
    public function testUpdatePosition()
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
        $response = $this->post(route('update.post'), [
            'name' => 'something',
            'name_parent_case' => 'something',
        ]);
        $response->assertSessionMissing(['name','name_parent_case']);
        $response->assertStatus(302);
    }

    /**
     * Удаление должности
     *
     * @return void
     */
    public function testDeletePosition()
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
        $response = $this->post(route('delete.post'), [
            'post_id' => $position->id,
        ]);
        $response->assertStatus(302)->assertSessionHas('deleteError');
    }

}
