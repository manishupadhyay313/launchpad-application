<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
            'name' => 'Math',
        ]);
        DB::table('subjects')->insert([
            'name' => 'PHP',
        ]);
        DB::table('subjects')->insert([
            'name' => 'Java',
        ]);
        DB::table('subjects')->insert([
            'name' => 'Dot Net',
        ]);
        DB::table('subjects')->insert([
            'name' => 'Python',
        ]);
        DB::table('subjects')->insert([
            'name' => 'Javascript',
        ]);
        DB::table('subjects')->insert([
            'name' => 'Jquery',
        ]);
        DB::table('subjects')->insert([
            'name' => 'React js',
        ]);
    }
}
