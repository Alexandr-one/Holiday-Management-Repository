<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\WithFaker;

trait CreatesUser
{
    use WithFaker;

    /**
     * Создание пользователя
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function createUser()
    {
        return factory(User::class)->create([
            'password' => password_hash($this->faker->word, PASSWORD_BCRYPT)
        ]);
    }
}
