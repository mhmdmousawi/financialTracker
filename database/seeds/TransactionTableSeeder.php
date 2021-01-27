<?php

use Illuminate\Database\Seeder;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transaction = new App\Transaction;
        $transaction->profile_id = 1 ;
        $transaction->title = "Work Salary"; 
        $transaction->type = 'income';
        $transaction->category_id = 1;
        $transaction->description = "My monthly income as a developer";
        $transaction->amount = 1700;
        $transaction->currency_id = 1;
        $transaction->repeat_id = 4;
        $transaction->start_date = date("2018-10-5");
        $transaction->end_date = date_create("2019-1-5");
        $transaction->save();

        $transaction = new App\Transaction;
        $transaction->profile_id = 1 ;
        $transaction->title = "Free Lance Income"; 
        $transaction->type = 'income';
        $transaction->category_id = 1;
        $transaction->description = "This is for a side project that I did for X company";
        $transaction->amount = 2000;
        $transaction->currency_id = 2;
        $transaction->repeat_id = 1;
        $transaction->start_date = date("2018-11-5");
        $transaction->save();

        $transaction = new App\Transaction;
        $transaction->profile_id = 1 ;
        $transaction->title = "T-shirt"; 
        $transaction->type = 'expense';
        $transaction->category_id = 3;
        $transaction->description = "A T shirt from America n Eagel that I liked";
        $transaction->amount = 50;
        $transaction->currency_id = 1;
        $transaction->repeat_id = 1;
        $transaction->start_date = date("2018-10-20");
        $transaction->save();

        $transaction = new App\Transaction;
        $transaction->profile_id = 1 ;
        $transaction->title = "Family Visit"; 
        $transaction->type = 'expense';
        $transaction->category_id = 4;
        $transaction->description = "For visiting my mom";
        $transaction->amount = 300;
        $transaction->currency_id = 1;
        $transaction->repeat_id = 4;
        $transaction->start_date = date("2018-9-20");
        $transaction->end_date = date_create("2019-1-10");
        $transaction->save();
        
        $transaction = new App\Transaction;
        $transaction->profile_id = 1 ;
        $transaction->title = "IphoneXr"; 
        $transaction->type = 'saving';
        $transaction->category_id = 5;
        $transaction->description = "Saving for the new iphoneXr";
        $transaction->amount = 100;
        $transaction->currency_id = 1;
        $transaction->repeat_id = 4;
        $transaction->start_date = date("2018-11-20");
        $transaction->end_date = date_create("2019-9-20");
        $transaction->save();


    }
}
