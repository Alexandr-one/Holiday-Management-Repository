<?php

namespace Tests\Feature\Admin;

use App\Classes\UserRolesEnum;
use App\Classes\UserStatusEnum;
use App\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class HistoryTest extends TestCase
{
    use CreatesUser, RefreshDatabase;
    /**
     * Посещение страниц историй.
     *
     * @return void
     */
    public function testVisitHistories()
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
        $response = $this->get(route('users.history'));
        $response->assertStatus(200);
        $response = $this->get(route('system.history'));
        $response->assertStatus(200);
        $response = $this->get(route('application.status.history'));
        $response->assertStatus(200);
    }
}
