<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Session;
use App\CustomClasses\Calculator;
use App\Repeat;

class DashboardController extends Controller
{
    private $user;
    private $calculate;
    private $dashboard_type; 
    private $top_number = 10;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->calculate = new Calculator;
            return $next($request);
        });
    }

    public function setDashboardType($type)
    {
        $this->dashboard_type = $type;
    }

    public function viewfilteredBySessionTime(){

        if(!Session::get('time_filter')){
            $now = date("Y-m-d");
            $this->setTimeFilter($now);
        }

        $time_filter = Session::get('time_filter');
        $type_filter = $time_filter['type_filter'];
        $date_filter = $time_filter['date_filter'];

        return $this->redirection($type_filter,$date_filter);
    }

    private function setTimeFilter($date)
    {
        $type_filter = "monthly";
        $date_filter = $date;

        $time_filter = [
            'type_filter' => $type_filter,
            'date_filter' => $date_filter
        ];
        Session::put('time_filter', $time_filter);
    }

    public function redirection($type_filter,$date_filter)
    {
        if($type_filter == 'weekly'){
            return $this->weekly($date_filter)
                        ->with('dashboard_type', $this->dashboard_type);
        }else if($type_filter == 'monthly'){
            return $this->monthly($date_filter)
                        ->with('dashboard_type',$this->dashboard_type);
        }else if( $type_filter == 'yearly'){
            return $this->yearly($date_filter)
                        ->with('dashboard_type',$this->dashboard_type);
        }else{
            return "404 Page not found..";
        }
    }

    public function weekly($date)
    {
        $carbon_date = Carbon::createFromFormat('Y-m-d', $date);
        $start_current_week = clone $carbon_date->startOfWeek();
        $end_current_week = clone $carbon_date->endOfWeek();

        if($this->dashboard_type == "overview"){
            $this->user = $this->getUserTopInfoCustomDuration(
                            $this->user,
                            $start_current_week,
                            $end_current_week
                        );
        }else{
            $this->user = $this->getUserInfoCustomDuration(
                            $this->user,
                            $start_current_week,
                            $end_current_week
                        );
        }
        return view('dashboard.'.$this->dashboard_type)->with('user',$this->user);
    }

    public function monthly($date)
    {
        $carbon_date = Carbon::createFromFormat('Y-m-d', $date);
        $start_current_month = clone $carbon_date->startOfMonth();
        $end_current_month = clone $carbon_date->endOfMonth();

        if($this->dashboard_type == "overview"){
            $this->user = $this->getUserTopInfoCustomDuration(
                        $this->user,
                        $start_current_month,
                        $end_current_month
                    );
        }else{
            $this->user = $this->getUserInfoCustomDuration(
                        $this->user,
                        $start_current_month,
                        $end_current_month
                    );
        }
        return view('dashboard.'.$this->dashboard_type)->with('user',$this->user);
    }

    public function yearly($date)
    {
        $carbon_date = Carbon::createFromFormat('Y-m-d', $date);
        $start_current_year = clone $carbon_date->startOfYear();
        $end_current_year = clone $carbon_date->endOfYear();

        if($this->dashboard_type == "overview"){
            $this->user = $this->getUserTopInfoCustomDuration(
                        $this->user,
                        $start_current_year,
                        $end_current_year
                    );
        }else{
            $this->user = $this->getUserInfoCustomDuration(
                        $this->user,
                        $start_current_year,
                        $end_current_year
                    );
        }

        return view('dashboard.'.$this->dashboard_type)->with('user',$this->user);   
    }

    private function getUserInfoCustomDuration(
        $user,
        $start_duration,
        $end_duration
    ){

        $transactions = $user->profile->transactionsInTimeFrame(
                                            $start_duration,
                                            $end_duration,
                                            $this->dashboard_type
                                        );
        $transactions =  json_decode($transactions);
        $user->expanded_transactions = $transactions;

        $user->stat_categories_info = $this->getCategoriesInfo(
                                            $user,
                                            $transactions
                                        );
        

        $total_amount = $this->getTotalAmount($user,$transactions);
        $user->total_amount = $total_amount;

        $this->addPercentages(
                    $user,
                    $user->expanded_transactions,
                    $total_amount);
        $daily_average = $this->getDailyAverage(
                                    $start_duration,
                                    $end_duration,
                                    $total_amount);
        $user->daily_average = $daily_average;

        return $user;
    }
    
    private function getUserTopInfoCustomDuration(
        $user,
        $start_duration,
        $end_duration
    ){
        $income_transactions = $user->profile->transactionsInTimeFrame(
                                            $start_duration,
                                            $end_duration,
                                            "income",
                                            $this->top_number);
        $income_transactions =  json_decode($income_transactions);
        usort($income_transactions, array($this, "sortByAmount"));
        $user->income_transactions = $this->getTopTransactions(
                                        $income_transactions
                                    );
        $user->stat_categories_info_income = $this->getCategoriesInfo(
                                                $user,
                                                $user->income_transactions
                                            );

        $expense_transactions = $user->profile->transactionsInTimeFrame(
                                            $start_duration,
                                            $end_duration,
                                            "expense",
                                            $this->top_number);
        $expense_transactions =  json_decode($expense_transactions);
        usort($expense_transactions, array($this, "sortByAmount"));
        $user->expense_transactions = $this->getTopTransactions(
                                        $expense_transactions
                                    );
        $user->stat_categories_info_expense = $this->getCategoriesInfo(
                                                $user,
                                                $user->expense_transactions
                                            );
        
        $saving_transactions = $user->profile->transactionsInTimeFrame(
                                            $start_duration,
                                            $end_duration,
                                            "saving",
                                            $this->top_number
                                        );
        $saving_transactions =  json_decode($saving_transactions);
        usort($saving_transactions, array($this, "sortByAmount"));
        $user->saving_transactions = $this->getTopTransactions(
                                        $saving_transactions
                                    );
        $user->stat_categories_info_saving = $this->getCategoriesInfo(
                                                $user,
                                                $user->saving_transactions
                                            );

        $user->money_in = $this->getTotalAmount($user,$income_transactions);
        $user->money_out = $this->getTotalAmount($user,$expense_transactions);
        $user->saving = $this->getTotalAmount($user,$saving_transactions);

        $user->balance= ($user->money_in) - ($user->money_out + $user->saving );
        

        return $user;
    }

    private function getTopTransactions($transactions)
    {
        $top_income_array = array();
        for( $i=0 ; $i < $this->top_number && $i < count($transactions); $i++ ){
            array_push($top_income_array,$transactions[$i]);
        }
        return $top_income_array;
    }

    private function sortByAmount($a, $b)
    {
        $amount_a = $this->calculate->defaultAmount($a->amount,$a->currency_id);
        $amount_b = $this->calculate->defaultAmount($b->amount,$b->currency_id);
        if($amount_a == $amount_b){ return 0 ; }
	    return ($amount_a > $amount_b) ? -1 : 1;
    }

    private function getCategoriesInfo($user,$transactions)
    {
        $grouped_categories = array();
        $category_title = array();
        $category_amounts = array();
        $category_info = array();

        foreach ($transactions as $transaction) {

            $grouped_categories[$transaction->category->title][] = [
                'amount' => $transaction->amount,
                'currency_id' => $transaction->currency_id];
        }
        foreach($grouped_categories as $key => $category_i){

            $cat_total_amount = 0;
            foreach($category_i as $key1 => $info){
                $cat_total_amount += $this->calculate->defaultAmount(
                                        $info['amount'],
                                        $info['currency_id']
                                    );
            }
            array_push($category_title,$key);
            array_push($category_amounts,$cat_total_amount);
        }
        array_push($category_info,$category_title);
        array_push($category_info,$category_amounts);

        return $category_info;
    }

    private function getDailyAverage($start_date,$end_date,$amount)
    {
        $days_differance = $end_date->diffInDays($start_date)+1;
        $average = round(($amount/$days_differance),2);
        return $average;
    }

    private function addPercentages($user,$transactions,$total_amount)
    {
        $default_currency_rate = $user->profile
                                      ->defaultCurrency
                                      ->amount_per_dollar;

        foreach($transactions as $transaction){
            $amount_in_default_curr = 
                ($transaction->amount*$default_currency_rate)
                    /($transaction->currency->amount_per_dollar);
            
            $transaction->percentage = 
                round($amount_in_default_curr/$total_amount*100,2);
        }
    }

    private function getTotalAmount($user ,$transactions)
    {
        $default_currency_rate = $user->profile
                                      ->defaultCurrency
                                      ->amount_per_dollar;
        $total_amount = 0 ;
        foreach($transactions as $transaction){
            $amount_in_default_curr = 
                ($transaction->amount*$default_currency_rate)
                    /($transaction->currency->amount_per_dollar);
            $total_amount+=$amount_in_default_curr;
        }
        return $total_amount;
    }


}
