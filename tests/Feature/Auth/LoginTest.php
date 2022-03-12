<?php

namespace Tests\Feature\Auth;

use App\Classes\UserStatusEnum;
use App\Position;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use CreatesUser, RefreshDatabase;

    /**
     * Тест проверки на возможность зайти на страницу авторизации.
     *
     * @return void
     */
    public function testLoginPage()
    {
        $response = $this->get(route('login.page'));

        $response->assertStatus(200);
    }

    /**
     * Проверка на то что авторизованный пользователь не может зайти в систему
     *
     * @return void
     */
    public function testAuthUserLoginPage()
    {
        $position = factory(Position::class)->create([
            'name' => 'name'
        ]);
        $user = factory(\App\User::class)->create([
            'position_id' => $position->id
        ]);

        Auth::login($user);

        $response = $this->get(route('login.page'));

        $response->assertStatus(302);
    }

    /**
     * Проверка на авторизацию пользователя
     *
     * @return void
     */
    public function testLoginUser()
    {
        $position = factory(Position::class)->create([
            'name' => 'name'
        ]);

        $user = factory(User::class)->create([
            'password' => password_hash($password = $this->faker->word, PASSWORD_BCRYPT),
            'position_id' => $position->id

        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticated();
        $this->assertEquals(Auth::id(), $user->id);
    }

    /**
     * Проверка на блокировку пользователя при авторизации
     *
     * @return void
     */
    public function testLoginBlockedUser()
    {
        $position = factory(Position::class)->create([
            'name' => 'name'
        ]);

        $user = factory(User::class)->create([
            'password' => password_hash($password = $this->faker->word, PASSWORD_BCRYPT),
            'status' => UserStatusEnum::BLOCKED,
            'blocked_reason' => 'Spam',
            'position_id' => $position->id
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('loginErrors', function ($value) use ($user) {
            return $value === 'Вы заблокированы. Причина: ' . $user->blocked_reason;
        });
    }

    /**
     * Проверка валидации при тестировании
     *
     * @return void
     */
    public function testLoginUserValidate()
    {
        // Проверка на формат email и на отсутсвие пароля
        $this->post(route('login'), [
            'email' => 'testemail'
        ])->assertSessionHasErrors(['email', 'password']);

        // Проверка на отсутсвие email в системе
        $this->post(route('login'), [
            'email' => 'test@email',
            'password' => 'secret'
        ])->assertSessionHasErrors(['email']);
    }

    /**
     * Проверка на данные пользователя при авторизации
     *
     * @return void
     */
    public function testLoginUserCredentials()
    {
        $position = factory(Position::class)->create([
            'name' => 'name'
        ]);
        $user = factory(User::class)->create([
            'password' => password_hash($password = 'secret', PASSWORD_BCRYPT),
            'position_id' => $position->id
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('loginErrors', function ($value) use ($user) {
            return $value === 'Неверно введены данные';
        });
    }
}
