<?php

use Illuminate\Database\Seeder;
use Tests\TestCase;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class, 1)->create(
            [
                'email' => TestCase::TEST_EMAIL,
                'password' => Hash::make(env('PASSWORD')),
            ]
        );
    }
}
