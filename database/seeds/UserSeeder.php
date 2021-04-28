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
    	\DB::table('users')->delete();
        
        // reset auto increment to zero
        \DB::statement('ALTER TABLE users AUTO_INCREMENT = 1;');

        \DB::table('users')->insert(array (
        	[
        		'name' => 'Thomas Shelby',
        		'email' => 'thomas@peakyblinders.com',
        		'password' => bcrypt('12341234'),
        		'created_at' => \Carbon::now()
        	]
        ));
    }
}
