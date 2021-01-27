<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Profile;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->email= 'admin@gmail.com';
        $user->password = bcrypt('password');
        $user->save();

        $profile = new Profile;
        $profile->id = $user->id;
        $profile->username = "admin";
        $profile->save();
    }
}
