<?php

use Illuminate\Database\Seeder;

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
                'name'      => 'abin jose',
                'user_name' => 'superadmin',
                'phone'     => '+918714439950',
                'password'  => Hash::make('123456'),
                'image'     => '/images/user/default_super_admin.png',
                'role'      => 0,
                'status'    => '1'
        ]);
    }
}
