<?php

use Illuminate\Database\Seeder;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Position::class)->create([
            'name' => 'Стажер',
            'name_parent_case' => "Стажера"
        ]);
    }
}
