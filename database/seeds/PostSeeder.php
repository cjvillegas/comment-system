<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Schema::disableForeignKeyConstraints();

        \DB::table('posts')->delete();
        
        // reset auto increment to zero
        \DB::statement('ALTER TABLE posts AUTO_INCREMENT = 1;');
        
        Schema::enableForeignKeyConstraints();

        \DB::table('posts')->insert(array (
        	[
    		'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        		'created_by' => 1,
        		'created_at' => \Carbon::now()
        	]
        ));
    }
}
