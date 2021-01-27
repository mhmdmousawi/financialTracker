<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Currency;
use App\Profile;

class ProfileController extends Controller
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
        return view('profile')->with('user',$this->user)
                              ->with('currencies',$currencies);
    }

    public function edit(Request $request)
    {
        $validatedData = $request->validate([
            'currency_select' => 'required|exists:currencies,id',
        ]);

        $profile = Profile::find($this->user->profile->id);
        $profile->default_currency_id = $request->currency_select;
        $profile->save();

        return redirect("/profile");
    }
}
