<?php

namespace Tests\Feature\Auth;

use App\Position;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use CreatesUser, RefreshDatabase;

    /**
     * Проверка сброса пароля.
     *
     * @return void
     */
    public function testUserChangePassword()
    {
        $position = factory(Position::class)->create([
            'name' => 'name'
        ]);
        $user = factory(User::class)->create([
            'reset_token' => 'secret',
            'position_id' => $position->id
        ]);

        $newPassword = 'secret';
        $this->post(route('password.change'), [
            'password' => $newPassword,
            'password_confirm' => $newPassword,
            'code' => $user->reset_token
        ])->assertStatus(302)
          ->assertSessionHas('successResetPassword', 'Ваш пароль успешно изменен');
    }

    /**
     * Проверка неверного кода
     *
     * @return void
     */
    public function testUserChangePasswordWithWrongCode()
    {
        $newPassword = 'secret';
        $this->post(route('password.change'), [
            'password' => $newPassword,
            'password_confirm' => $newPassword,
            'code' => 'code',
        ])->assertStatus(302)
            ->assertSessionHas('errorCode', 'Неверный код');
    }
}
