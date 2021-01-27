<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use App\User;
use Session;
use Validator;
use App\Currency;
use App\Repeat;

use App\CustomClasses\Calculator;

class AddSavingController extends Controller
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

    public function index()
    {
        $currencies = Currency::all();
        $repeats = Repeat::all();
        return view('saving.add')->with('user',$this->user)
                                      ->with('currencies',$currencies)
                                      ->with('repeats',$repeats);
    }

    public function validateAndAdd(Request $request)
    {
        

        $validatedData = $request->validate([
            'goal_amount' => 'required|numeric',
            'amount' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'max:255',
            'currency_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'repeat_id' => 'required|numeric|in:3,4',
            'start_date' => 'required|date',
        ]);

        $goal_amount_tr = $request->goal_amount;
        $amount_tr = $request->amount;
        $currency_id = $request->currency_id;
        $repeat_id = $request->repeat_id;
        $start_date = $request->start_date;

        $goal_amount = $this->calculate
                            ->defaultAmount($goal_amount_tr,$currency_id);
        $amount = $this->calculate
                        ->defaultAmount($amount_tr,$currency_id);
        $due_date = $this->calculate
                        ->dueDate($goal_amount,$amount,$start_date,$repeat_id);

        $isValid_goal = $this->goalValid($goal_amount,$due_date);
        $isValid_fequently = $this->frequentlyValid(
                                $amount,
                                $start_date,
                                $due_date,
                                $repeat_id
                            );

        if($isValid_goal && $isValid_fequently){
            $this->adding($request,$due_date);
            return redirect('/dashboard/savings');
        }

        return "404 page not found .. don't play around";
    }

    public function adding(Request $request,$due_date)
    {
        $transaction = new Transaction;
        $transaction->profile_id = $this->user->profile->id;
        $transaction->amount = $request->amount;
        $transaction->type = "saving";
        $transaction->title = $request->title;
        $transaction->description = $request->description;
        $transaction->currency_id = $request->currency_id;
        $transaction->category_id = $request->category_id;
        $transaction->repeat_id = $request->repeat_id;
        $transaction->start_date = $request->start_date;
        $transaction->end_date = $due_date;
        $transaction->save();
        return true;
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

                $week_overall_before_savings = $this->calculate
                                                ->weekOverallCalculation(
                                                    $recurrent_save_date
                                                        ->format('Y-m-d')
                                                );
                $amount_saved = $saving_number * $amount;
                $week_overall_after_savings = $week_overall_before_savings 
                                                - $amount_saved;
                
                if($amount > ($week_overall_after_savings+$amount)){
                    return false;
                }else{
                    $saving_number++;
                }
                $recurrent_save_date = $recurrent_save_date
                                            ->add(new DateInterval('P1W'));

            }else if($repeat_id == 4){

                $month_overall_before_savings = $this->calculate
                                                    ->monthOverallCalculation(
                                                        $recurrent_save_date
                                                            ->format('Y-m-d')
                                                    );
                $amount_saved = $saving_number*$amount;
                $month_overall_after_savings = $month_overall_before_savings 
                                                - $amount_saved;
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

    public function confirm(Request $request)
    {
        if(isset($request->confirm)){
            if(Session::get('saving_valid')){

                $session_data = Session::get('saving_valid');
                $transaction = new Transaction;
                $transaction->profile_id = $this->user->profile->id;
                $transaction->amount = $session_data['amount'];
                $transaction->type = "saving";
                $transaction->title = $session_data['title'];
                $transaction->description = $session_data['description'];
                $transaction->currency_id = $session_data['currency_id'];
                $transaction->category_id = $session_data['category_id'];
                $transaction->repeat_id = $session_data['repeat_id'];
                $transaction->start_date = $session_data['start_date'];
                $transaction->end_date = $session_data['end_date'];
                $transaction->save();

                Session::forget('saving_valid');
            }
        }else if(isset($request->cancel)){
            return view('saving_add')->with('user',$this->user);
        }else{
            return "Some Error Happened";
        }
    
        return redirect('/dashboard/savings/monthly');
    }

    
}
