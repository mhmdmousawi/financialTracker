<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Currency;
use App\Repeat;
use App\CustomClasses\Calculator;
use Session;

use DateTime;
use DateInterval;

class AddSmartSavingController extends Controller
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
        return view('smart_saving.add')->with('user',$this->user)
                                      ->with('currencies',$currencies)
                                      ->with('repeats',$repeats);
    }

    public function confirmed(Request $request)
    {
        if($request->session()->has('valid_transaction')){
            $transaction = $request->session()->get('valid_transaction');
            $transaction->save();
            $request->session()->forget('valid_transaction');
            return redirect('/dashboard/savings');
        }else{
            return "no smart saving plan to confirm..";
        }
    }

}
