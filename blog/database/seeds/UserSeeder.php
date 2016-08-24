<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class UserSeeder extends Seeder
{

	public function run()
	{

		DB::table('users')->insert([
				'name'		=>	'Pedrito Perez',
				'email'		=>	'pedro@gmail.com',
				'password'	=>	bcrypt('pedrito'),
				'type'		=>	'admin'

			]);

	}
}