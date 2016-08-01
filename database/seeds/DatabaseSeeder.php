<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserTableSeeder::class);
        
        DB::table('category')->insert([

        	'title' => 'test 1',
        	'description' => 'test',
            'name'	=> 'test 1'

        	]);
        DB::table('tags')->insert([

            'title' => 'test 1',
            'description' => 'test',
            'name'	=> 'test 1'

        ]);



    }
}
