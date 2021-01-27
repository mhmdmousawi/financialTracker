<?php

use Illuminate\Database\Seeder;

class RepeatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('repeats')->insert(['type' => 'fixed']);
        DB::table('repeats')->insert(['type' => 'daily']);
        DB::table('repeats')->insert(['type' => 'weekly']);
        DB::table('repeats')->insert(['type' => 'monthly']);
    }
}
