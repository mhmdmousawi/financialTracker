<?php

use Illuminate\Database\Seeder;

class LogoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('logos')->insert(['class_name' => "glyphicon glyphicon-glass"]);
        DB::table('logos')->insert(['class_name' => "glyphicon glyphicon-plane"]);
        DB::table('logos')->insert(['class_name' => "glyphicon glyphicon-gift"]);
        DB::table('logos')->insert(['class_name' => "glyphicon glyphicon-shopping-cart"]);
        DB::table('logos')->insert(['class_name' => "glyphicon glyphicon-briefcase"]);
        DB::table('logos')->insert(['class_name' => "glyphicon glyphicon-heart-empty"]);
        DB::table('logos')->insert(['class_name' => "glyphicon glyphicon-apple"]);
        DB::table('logos')->insert(['class_name' => "glyphicon glyphicon-piggy-bank"]);
        DB::table('logos')->insert(['class_name' => "glyphicon glyphicon-sunglasses"]);
        DB::table('logos')->insert(['class_name' => "glyphicon glyphicon-tent"]);
        DB::table('logos')->insert(['class_name' => "glyphicon glyphicon-usd"]);
        DB::table('logos')->insert(['class_name' => "glyphicon glyphicon-tint"]);
        
    }
}
