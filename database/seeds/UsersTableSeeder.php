<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'beheerder@halo.com',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
