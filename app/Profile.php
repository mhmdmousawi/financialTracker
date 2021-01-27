<?php

namespace App;
use DateTime;
use DateInterval;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User','id');
    }

    public function defaultCurrency()
    {
        return $this->belongsTo('App\Currency','default_currency_id');
    }

    public function categories()
    {
        return $this->hasMany('App\Category','profile_id','id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction','profile_id','id');
    }

    public function transactionsWithType($type)
    {
        $transactions = $this->transactions()
                             ->where("type",$type)
                             ->get();
        return $transactions;
    }

    public function transactionsWithTypeAndRepeat($type)
    {
        $transactions = $this->transactionsWithType($type);

        $filtered_transactions = [];
        foreach ($transactions as $transaction) {
        
            $ts_date = new DateTime($transaction->start_date);
            $te_date = new DateTime($transaction->end_date);

            if($transaction->repeat->type == 'fixed'){
                $transaction->category;
                $transaction->currency;
                $transaction->category->logo;
                $transaction->repeat;
                array_push($filtered_transactions, $transaction);
            }else{
                $recurrent_start = $ts_date;
                $recurrent_end = $te_date;

                while($recurrent_start < $recurrent_end){

                    $transaction->start_date = $recurrent_start
                                                    ->format('Y-m-d');
                    $transaction->category;
                    $transaction->currency;
                    $transaction->category->logo;
                    $transaction->repeat;
                    array_push($filtered_transactions, clone $transaction);
                    

                    if($transaction->repeat->type == 'daily'){
                        $recurrent_start = $recurrent_start
                                            ->add(new DateInterval('P1D'));
                    }else if($transaction->repeat->type = 'weekly'){
                        $recurrent_start = $recurrent_start
                                            ->add(new DateInterval('P1W'));
                    }else if($transaction->repeat->type = 'monthly'){
                        $recurrent_start = $recurrent_start
                                            ->add(new DateInterval('P1M'));
                    }
                }
            }
        }
        return json_encode($filtered_transactions);
    }

    public function transactionsWithTypeAndRepeatUntil( $date, $type = null)
    {
        if($type === null){
            $transactions = $this->transactions()->get();
        }else{
            $transactions = $this->transactionsWithType($type);
        }
        $date = new DateTime($date);

        $filtered_transactions = [];
        foreach ($transactions as $transaction) {

            $ts_date = new DateTime($transaction->start_date);
            $te_date = new DateTime($transaction->end_date);

            if($transaction->repeat->type == 'fixed'){
                
                if( $ts_date <= $date ){
                    $transaction->category;
                    $transaction->currency;
                    $transaction->category->logo;
                    $transaction->repeat;
                    array_push($filtered_transactions, $transaction);
                }
                
            }else {
            
                $recurrent_start = $ts_date;
                $recurrent_end = $te_date;

                while($recurrent_start < $recurrent_end){

                    if($recurrent_start <= $date){
                        $transaction->start_date = $recurrent_start
                                                    ->format('Y-m-d');
                        $transaction->category;
                        $transaction->currency;
                        $transaction->category->logo;
                        $transaction->repeat;
                        array_push($filtered_transactions, clone $transaction);
                    }

                    if($transaction->repeat->type == 'daily'){
                        $recurrent_start = $recurrent_start
                                                ->add(new DateInterval('P1D'));
                    }else if($transaction->repeat->type == 'weekly'){
                        $recurrent_start = $recurrent_start
                                                ->add(new DateInterval('P1W'));
                    }else if($transaction->repeat->type == 'monthly'){
                        $recurrent_start = $recurrent_start
                                                ->add(new DateInterval('P1M'));
                    }
                }
            }
        }
        return json_encode($filtered_transactions);
    
    }

    private function transactionsWithTypeTop($type,$top)
    {
        $transactions = $this->transactions()
                             ->where("type",$type)
                             ->orderBy("amount",'DESC')
                             ->limit($top)
                             ->get();
        return $transactions;
    }

    public function transactionsInTimeFrame(
        $ss_date,
        $se_date,
        $type = null,
        $top = null
    ){

        if($type === null){
            $transactions = $this->transactions()->get();
        }else{
            if($top === null){
                $transactions = $this->transactionsWithType($type);
            }else{
                $transactions = $this->transactionsWithTypeTop($type,$top);                   
            }
        }
        $ss_date = new DateTime($ss_date);
        $se_date = new DateTime($se_date);

        $filtered_transactions = [];
        foreach ($transactions as $transaction) {

            $ts_date = new DateTime($transaction->start_date);
            $te_date = new DateTime($transaction->end_date);

            if($transaction->repeat->type == 'fixed'){
                
                if($ts_date >= $ss_date && $ts_date <= $se_date ){
                    $transaction->category;
                    $transaction->currency;
                    $transaction->category->logo;
                    $transaction->repeat;
                    array_push($filtered_transactions, $transaction);
                }
                
            }else {
                $recurrent_start = $ts_date;
                $recurrent_end = $te_date;

                while($recurrent_start <= $recurrent_end){

                    if(($recurrent_start >= $ss_date) && 
                        ($recurrent_start <= $se_date)
                    ){
                        $transaction->start_date = $recurrent_start
                                                    ->format('Y-m-d');
                        $transaction->category;
                        $transaction->currency;
                        $transaction->category->logo;
                        $transaction->repeat;
                        array_push($filtered_transactions, clone $transaction);
                    }

                    if($transaction->repeat->type == 'daily'){
                        $recurrent_start = $recurrent_start
                                                ->add(new DateInterval('P1D'));
                    }else if($transaction->repeat->type == 'weekly'){
                        $recurrent_start = $recurrent_start
                                                ->add(new DateInterval('P1W'));
                    }else if($transaction->repeat->type == 'monthly'){
                        $recurrent_start = $recurrent_start
                                                ->add(new DateInterval('P1M'));
                    }
                }
            }
        }
        return json_encode($filtered_transactions);
    }

}
