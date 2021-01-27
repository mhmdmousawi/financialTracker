<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class TimeFilterController extends Controller
{
    public function change(Request $request)
    {
        $validatedData = $request->validate([
            'type_filter' => 'required|in:weekly,monthly,yearly',
            'date_filter' => 'required|date',
            'dashboard_type' => 'required|in:overview,income,expense,saving'
        ]);

        $type_filter = $request->type_filter;
        $date_filter = $request->date_filter;
        $dashboard_type = $request->dashboard_type;
        $this->setTimeFilter($type_filter,$date_filter);

        return $this->redirection($dashboard_type);

    }
    private function redirection($dashboard_type)
    {
        if($dashboard_type == "overview"){
            return redirect('/dashboard/overview');
        }else if($dashboard_type == "income"){
            return redirect('/dashboard/incomes');
        }else if($dashboard_type == "expense"){
            return redirect('/dashboard/expenses');
        }else if($dashboard_type == "saving"){
            return redirect('/dashboard/savings');
        }
        return "404 page not found";
    }
    private function setTimeFilter($type_filter,$date)
    {
        $type_filter = $type_filter;
        $date_filter = $date;

        $time_filter = [
            'type_filter' => $type_filter,
            'date_filter' => $date_filter
        ];
        Session::put('time_filter', $time_filter);
        return true;
    }
}
