<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use App\Currency;
use App\Repeat;

class AddTransactionController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $currencies = Currency::all();
        $repeats = Repeat::all();
        return view('transaction.add')->with('user',$this->user)
                                      ->with('currencies',$currencies)
                                      ->with('repeats',$repeats);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|max:1000000',
            'type' => 'required|in:income,expense,saving',
            'title' => 'required|max:255',
            'description' => 'max:255',
            'currency_id' => 'required|exists:currencies,id',
            'category_id' => 'required|exists:categories,id',
            'repeat_id' => 'required|numeric|in:1,2,3,4',
            'start_date' => 'required|date|before:tomorrow',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $transaction = new Transaction;
        $transaction->profile_id = $this->user->profile->id;
        $transaction->amount = $request->amount;
        $transaction->type = $request->type;
        $transaction->title = $request->title;
        $transaction->description = $request->description;
        $transaction->currency_id = $request->currency_id;
        $transaction->category_id = $request->category_id;
        $transaction->repeat_id = $request->repeat_id;
        $transaction->start_date = $request->start_date;
        $transaction->end_date = $request->end_date;
        $transaction->save();

        if($request->type == "income"){
            return redirect('/dashboard/incomes');
        }else if ($request->type == "expense"){
            return redirect('/dashboard/expenses');
        }

        return redirect('/dashboard/overview');

    }
}
