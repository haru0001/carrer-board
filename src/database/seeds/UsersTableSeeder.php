<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'name' => 'test_name',
            'email' => 'test@gmail.com',
            'password' => bcrypt('secret'),
            'se_career' => 1,
            'introduction' => 'test',
            'img_path' => 'test_img',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
