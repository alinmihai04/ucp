<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->where('name', 'like', '%seed%')->update(['last_login' => strtotime('today')]);
    }
}
