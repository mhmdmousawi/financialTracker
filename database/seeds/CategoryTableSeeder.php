<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new App\Category;
        $category->profile_id = 1;
        $category->type = 'income';
        $category->title = 'Salary';
        $category->logo_id = 11;
        $category->save();  

        $category = new App\Category;
        $category->profile_id = 1;
        $category->type = 'income';
        $category->title = 'Gift';
        $category->logo_id = 3;
        $category->save(); 

        $category = new App\Category;
        $category->profile_id = 1;
        $category->type = 'expense';
        $category->title = 'Shopping';
        $category->logo_id = 4;
        $category->save(); 

        $category = new App\Category;
        $category->profile_id = 1;
        $category->type = 'expense';
        $category->title = 'Traveling';
        $category->logo_id = 2;
        $category->save(); 

        $category = new App\Category;
        $category->profile_id = 1;
        $category->type = 'saving';
        $category->title = 'IPhone';
        $category->logo_id = 7;
        $category->save(); 

        $category = new App\Category;
        $category->profile_id = 1;
        $category->type = 'saving';
        $category->title = 'Valentines';
        $category->logo_id = 6;
        $category->save(); 

        $category = new App\Category;
        $category->profile_id = 1;
        $category->type = 'saving';
        $category->title = 'Smart Saving';
        $category->logo_id = 8;
        $category->save(); 

        
    }
}
