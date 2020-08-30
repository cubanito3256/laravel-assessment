<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::getQuery()->delete();

        factory(App\User::class, 100)->create()->each(function ($user) {
            //var_dump($user);
            $user->make();
        });
    }
}
