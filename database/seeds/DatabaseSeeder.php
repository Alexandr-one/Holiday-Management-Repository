<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Загрузка начальных данных
     *
     * @return void
     */
    public function run()
    {
        $this->call(PositionTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(OrganizationTableSeeder::class);
    }
}
