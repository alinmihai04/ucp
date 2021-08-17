<?php

use Illuminate\Database\Seeder;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for($i = 0; $i < 1000; $i++)
    	{
	         DB::table('users')->insert([
	            'name' => str_random(10),
	            'user_email' => str_random(10).'@gmail.com',
	            'password' => 'secret',
                'user_hours' => 1,
	        ]);   		
	     }
    }
}
