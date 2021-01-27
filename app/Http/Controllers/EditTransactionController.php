<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use App\Currency;
use App\Repeat;
use App\User;


class EditTransactionController extends Controller
{
    private $user;

    public function __construct(Auth $id)
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index($transaction_id)
    {
        $transaction = Transaction::where('id',$transaction_id)
                                    ->where(
                                        'profile_id',
                                        $this->user->profile->id
                                    )->first();
        $currencies = Currency::all();
        $repeats = Repeat::all();
        
        if(!$transaction){
            return '404 page';
        }
        if($transaction->type == "saving"){
            return "Don't Even try .. :) ";
        }
        
        return view('transaction.edit')->with('user',$this->user)
                                      ->with('transaction',$transaction)
                                      ->with('currencies',$currencies)
                                      ->with('repeats',$repeats);
    }

    public function delete(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:transactions,id',
        ]);

        $transaction_id = $request->id;
        $transaction = Transaction::where('id',$transaction_id)
                                    ->where(
                                        'profile_id',
                                        $this->user->profile->id
                                    )->first();
        $transaction->delete();
        return $this->redirection($transaction);

    }

    public function edit(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:transactions,id',
            'amount' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'max:255',
            'currency_id' => 'required|exists:currencies,id',
            'edit_type' => 'required|in:all,future',
        ]);

        $edit_type = $request->edit_type;
        $transaction_id = $request->id;
        $transaction = Transaction::where('id',$transaction_id)
                                    ->where(
                                        'profile_id',
                                        $this->user->profile->id
                                    )->first();
        if(!$transaction){
            return '404 page';
        }
        if($transaction->type == "saving"){
            return "Please don't try injections .. :) ";
        }

        $t_end_date = new DateTime($transaction->end_date);
        $t_start_date = new DateTime($transaction->start_date);
        $today = new Datetime (date("Y-m-d"));

        if($t_end_date <= $today){
            $edit_type = "all";
        }

        if($edit_type == "future"){
            $new_transaction = new Transaction;
            $new_transaction->profile_id = $transaction->profile_id; //same
            $new_transaction->amount = $request->amount;
            $new_transaction->type = $transaction->type; //same
            $new_transaction->title = $request->title;
            $new_transaction->description = $request->description;
            $new_transaction->currency_id = $request->currency_id;
            $new_transaction->category_id = $transaction->category_id; //same
            $new_transaction->repeat_id = $transaction->repeat_id; //same

            $next_start_date = $this->getNextStartDate($transaction);
            $new_transaction->start_date = $next_start_date;
            $new_transaction->end_date = $transaction->end_date; //same
            $new_transaction->save();

            $last_end_date = $this->getLastEndDate(
                                $transaction,
                                $next_start_date
                            );
            $transaction->end_date = $last_end_date;
            $transaction->save();

            return $this->redirection($transaction);

        }else if($edit_type == "all"){
            $transaction->amount = $request->amount;
            $transaction->title = $request->title;
            $transaction->description = $request->description;
            $transaction->currency_id = $request->currency_id;
            $transaction->save();
            return $this->redirection($transaction);
        }else{
            return "404 page";
        }
    }

    public function redirection($transaction)
    {
        if($transaction->type == "income"){
            return redirect('/dashboard/incomes');
        }else if ($transaction->type == "expense"){
            return redirect('/dashboard/expenses');
        }
        return "404 page";
    }

    public function getLastEndDate($transaction,$next_start_date)
    {
        $next_start_date = new DateTime($next_start_date);
        if($transaction->repeat->type == 'daily'){
            $last_end_date = $next_start_date->sub(new DateInterval('P1D'));
        }else if($transaction->repeat->type = 'weekly'){
            $last_end_date = $next_start_date->sub(new DateInterval('P1W'));
        }else if($transaction->repeat->type = 'monthly'){
            $last_end_date = $next_start_date->sub(new DateInterval('P1M'));
        }
        return $last_end_date->format("Y-m-d");
    }

    public function getNextStartDate($transaction){

        $t_start_date = $transaction->start_date;
        $t_end_date =$transaction->end_date;
        $t_repeat_id = $transaction->repeat_id;

        $next_start_date = new DateTime($t_start_date);
        $today = new DateTime(date("Y-m-d"));
        
        while($next_start_date < $today){
            if($transaction->repeat->type == 'daily'){
                $next_start_date = $next_start_date
                                        ->add(new DateInterval('P1D'));
            }else if($transaction->repeat->type = 'weekly'){
                $next_start_date = $next_start_date
                                        ->add(new DateInterval('P1W'));
            }else if($transaction->repeat->type = 'monthly'){
                $next_start_date = $next_start_date
                                        ->add(new DateInterval('P1M'));
            }
        }
        return $next_start_date->format("Y-m-d");
    }
}
