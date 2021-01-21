<?php

use App\User;
use Illuminate\Database\Seeder;

class BasicUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->username = "test";
        $user->hash = app('hash')->make("testPassword");
        $user->save();
    }
}
