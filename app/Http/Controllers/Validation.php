<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\CustomClasses\Calculator;
use App\Transaction;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use Validator;
use Session;


class Validation extends Controller
{
    private $user;
    private $calculate;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->calculate = new Calculator;
            return $next($request);
        });
    }

    public function validateSmartSaving(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'goal_amount' => 'required|numeric|max:1000000000',
            'title' => 'required|max:255',
            'description' => 'max:255',
            'currency_id' => 'required|numeric|exists:currencies,id',
            'start_date' => 'required|date|after:yesterday',
            'end_date' => 'required|date|after:start_date',
            'priority' => 'required|in:time,money',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 401);
        }

        $isValid_fequently = false;
        $valid_response = false;
        $priority = $request->priority;
        $goal_amount = $this->calculate->defaultAmount(
                                    $request->goal_amount,
                                    $request->currency_id
                                );
        $start_date = $request->start_date;
        $end_date = $request->end_date; 

        $new_end_date = $end_date;
        $monthly_valid_info = array();
        
        
        $isValid_goal = $this->goalValid($goal_amount,$end_date);

        if($priority == "money"){
            $weekly_valid_info = $this->goalAmountFrequentlyValidInfo(
                                    $goal_amount,
                                    $start_date,
                                    $end_date,
                                    3
                                );
            $monthly_valid_info  = $this->goalAmountFrequentlyValidInfo(
                                        $goal_amount,
                                        $start_date,
                                        $end_date,
                                        4
                                   );
            
            $weekly_valid_info['valid'] = true;
            if($weekly_valid_info['valid']){
                $repeat_id = 3;
                $amount = $weekly_valid_info['amount'];
                $isValid_fequently = true;
            }
            if($monthly_valid_info['valid']){
                $repeat_id = 4;
                $amount = $monthly_valid_info['amount'];
                $isValid_fequently = true;
            } 
        }else{
            //if time is priority
            $most_recent_valid_end_date_monthly = 
                $this->getMostRecentValidEndDateMonthly(
                    $goal_amount,
                    $start_date,
                    $end_date
                );
            $monthly_valid_info  = 
                $this->goalAmountFrequentlyValidInfo(
                    $goal_amount,
                    $start_date,
                    $most_recent_valid_end_date_monthly,
                    4
                );                            
            if($monthly_valid_info['valid']){

                $new_end_date = $most_recent_valid_end_date_monthly;
                $repeat_id = 4;
                $amount = $monthly_valid_info['amount'];
                $isValid_fequently = true;

                if($start_date == $most_recent_valid_end_date_monthly 
                ){
                    $repeat_id = 1;
                }
            }

            $most_recent_valid_end_date_weekly = 
                $this->getMostRecentValidEndDateWeekly(
                    $goal_amount,
                    $start_date,
                    $end_date
                );
            $weekly_valid_info  = 
                $this->goalAmountFrequentlyValidInfo(
                    $goal_amount,
                    $start_date,
                    $most_recent_valid_end_date_weekly,
                    3
                );

            if($weekly_valid_info['valid']){

                $new_end_date = $most_recent_valid_end_date_weekly;
                $repeat_id = 3;
                $amount = $weekly_valid_info['amount'];
                $isValid_fequently = true;

                if($start_date == $most_recent_valid_end_date_weekly
                ){
                    $repeat_id = 1;
                }
            }
        }
            
        if($isValid_goal && $isValid_fequently){

            $valid_response = true;

            $transaction = new Transaction;
            $transaction->profile_id = $this->user->profile->id;
            $transaction->amount = $this->calculate->exchangeFromDefault(
                                        $amount,
                                        $request->currency_id
                                    ); 
            $transaction->type= "saving";
            $transaction->title = $request->title;
            $transaction->description = $request->description;
            $transaction->currency_id = $request->currency_id;
            $transaction->category_id = 7;
            $transaction->start_date = $request->start_date;
            $transaction->end_date = $new_end_date;
            $transaction->repeat_id = $repeat_id;

            $request->session()->put('valid_transaction', $transaction);

            //testing
            $array = [
                'verified' => true,
                'transaction_details' => $transaction,
                'monthly_valid_info' => $monthly_valid_info,
            ];
            return response()->json($array,200);
        }else{

            //testing
            $array = [
                'verified' => false,
                'monthly_valid_info' => $monthly_valid_info,
            ];
            return response()->json($array,200);
        }
    }

    public function validateSaving(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'goal_amount' => 'required|numeric|max:1000000000',
            'amount' => 'required|max:1000000',
            'title' => 'required|max:255',
            'description' => 'max:255',
            'currency_id' => 'required|numeric|exists:currencies,id',
            'category_id' => 'required|numeric|exists:categories,id',
            'repeat_id' => 'required|numeric|in:3,4',
            'start_date' => 'required|date|after:yesterday',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 401);
        }
        
        $goal_amount_tr = $request->goal_amount;
        $amount_tr = $request->amount;
        $currency_id = $request->currency_id;
        $repeat_id = $request->repeat_id;
        $start_date = $request->start_date;
        
        
        $goal_amount = $this->calculate->defaultAmount(
                            $goal_amount_tr,
                            $currency_id
                        );
        $amount = $this->calculate->defaultAmount(
                    $amount_tr,
                    $currency_id
                );
        $due_date = $this->calculate->dueDate(
                        $goal_amount,
                        $amount,
                        $start_date,
                        $repeat_id
                    );

        $isValid_goal = $this->goalValid($goal_amount,$due_date);
        $isValid_fequently = $this->frequentlyValid(
                                $amount,
                                $start_date,
                                $due_date,
                                $repeat_id
                            );
        
        $valid_response = false;

        if($isValid_goal && $isValid_fequently){
            $valid_response = true;
        }

        $array = [
            'request_params' => $request->all(),
            'end_date' => $due_date,
            'verified' => $valid_response,
        ];

        return response()->json($array,200);
    }

    public function goalValid($goal_amount,$due_date)
    {
        $overall_balance = $this->calculate->overallCalculationUntil($due_date);
        $dif = $overall_balance - $goal_amount;

        if($dif<0){
            return false;
        }
        return true;
    }

    public function frequentlyValid($amount,$start_date,$end_date,$repeat_id)
    {
        $start_date = new DateTime($start_date);
        $end_date = new DateTime($end_date);
        $recurrent_save_date = $start_date;
        $saving_number = 1;

        while($recurrent_save_date <= $end_date){

            if($repeat_id == 3){
                
                $week_overall_before_savings = 
                    $this->calculate->weekOverallCalculation(
                        $recurrent_save_date->format('Y-m-d')
                    );
                $amount_saved = $saving_number * $amount;
                $week_overall_after_savings = 
                    $week_overall_before_savings - $amount_saved;

                if($amount > ($week_overall_after_savings+$amount)){
                    return false;
                }else{
                    $saving_number++;
                }
                $recurrent_save_date = $recurrent_save_date
                                            ->add(new DateInterval('P1W'));

            }else if($repeat_id == 4){

                $month_overall_before_savings = 
                    $this->calculate->monthOverallCalculation(
                        $recurrent_save_date->format('Y-m-d')
                    );
                $amount_saved = $saving_number*$amount;
                $month_overall_after_savings = 
                    $month_overall_before_savings - $amount_saved;

                if($amount > ($month_overall_after_savings+$amount)){
                    return false;
                }else{
                    $saving_number++;
                }
                $recurrent_save_date = $recurrent_save_date
                                            ->add(new DateInterval('P1M'));
            } 
        }
        return true;
    }

    public function goalAmountFrequentlyValidInfo(
        $goal_amount,
        $start_date,
        $end_date,
        $repeat_id
    ){
        $valid_info = array();
        
        if($repeat_id == 3){
            //weekly
            $number_of_weeks = $this->calculate->numberOfWeeks(
                                    $start_date,
                                    $end_date
                                );
            if($number_of_weeks == 0){
                $number_of_weeks = 1;
            }
            $amount_weekly = $goal_amount/$number_of_weeks;
            $weekly_valid = $this->frequentlyValid(
                                $amount_weekly,
                                $start_date,
                                $end_date,
                                3
                            ); 

            $valid_info['valid'] = $weekly_valid;
            $valid_info['amount'] = $amount_weekly;
            
        }else if($repeat_id == 4){
            //monthly
            $number_of_months = $this->calculate->numberOfMonths(
                                    $start_date,
                                    $end_date
                                );
            if($number_of_months == 0){
                $number_of_months = 1;
            }
            $amount_monthly = $goal_amount/$number_of_months;
            $monthly_valid  = $this->frequentlyValid(
                                    $amount_monthly,
                                    $start_date,
                                    $end_date,
                                    4
                                );

            $valid_info['valid'] = $monthly_valid;
            $valid_info['amount'] = $amount_monthly;
        }
        return $valid_info; 
    }

    public function getMostRecentValidEndDateMonthly(
        $goal_amount,
        $start_date,
        $end_date
    ){
        $monthly_valid_info = array();
        $start_date_dt = new DateTime($start_date);
        $end_date_dt = new DateTime($end_date);
        $recurrent_end_date_dt =  $start_date_dt->add(new DateInterval('P1M'));
        
        while($recurrent_end_date_dt <= $end_date_dt){

            $number_of_months = $this->calculate->numberOfMonths(
                                    $start_date,
                                    $recurrent_end_date_dt->format('Y-m-d')
                                );
            $amount_monthly = $goal_amount/$number_of_months;
            $monthly_valid  = $this->frequentlyValid(
                                $amount_monthly,
                                $start_date,
                                $recurrent_end_date_dt->format('Y-m-d'),
                                4
                            );

            if($monthly_valid){
                break;
            }else{
                $recurrent_end_date_dt = $recurrent_end_date_dt
                                            ->add(new DateInterval('P1M'));
            }         
        }
        return $recurrent_end_date_dt
                    ->sub(new DateInterval('P1M'))->format('Y-m-d');
    }

    public function getMostRecentValidEndDateWeekly(
        $goal_amount,
        $start_date,
        $end_date
    ){
        $monthly_valid_info = array();
        $start_date_dt = new DateTime($start_date);
        $end_date_dt = new DateTime($end_date);
        $recurrent_end_date_dt =  $start_date_dt->add(new DateInterval('P1W'));
        
        while($recurrent_end_date_dt <= $end_date_dt){

            $number_of_months = $this->calculate->numberOfWeeks(
                                    $start_date,
                                    $recurrent_end_date_dt->format('Y-m-d')
                                );
            $amount_monthly = $goal_amount/$number_of_months;
            $monthly_valid  = $this->frequentlyValid(
                                    $amount_monthly,
                                    $start_date,
                                    $recurrent_end_date_dt->format('Y-m-d'),
                                    4
                                );

            if($monthly_valid){
                break;
            }else{
                $recurrent_end_date_dt = $recurrent_end_date_dt
                                            ->add(new DateInterval('P1W'));
            }         
        }
        return $recurrent_end_date_dt
                    ->sub(new DateInterval('P1W'))->format('Y-m-d');
    }
}