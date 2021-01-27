<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(RepeatTableSeeder::class);
        $this->call(CurrencyTableSeeder::class);
        $this->call(LogoTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(TransactionTableSeeder::class);
    }
}
