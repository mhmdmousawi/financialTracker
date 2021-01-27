<?php

use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $codes = ['USD','EUR', 'GBP','CAD','AUD','JPY','CNY'];
        $names = ['Dollar','Euro','British Pound','Canadian Dollar',
                  'Australian Dollar','Japanese Yen',
                  'Chinese Yuan Renminbi'];
        $valus = [1,0.86228,0.76860,1.30620,1.40348,111.287,6.86824];

        
        for( $i = 0 ; $i < count($codes) ; $i++ ){
            DB::table('currencies')->insert([
                'code' => $codes[$i],
                'name' => $names[$i],
                'amount_per_dollar' => $valus[$i],
            ]);
        }
    }
}
