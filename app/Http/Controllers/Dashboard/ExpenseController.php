<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Http\Request;

class ExpenseController extends DashboardController
{
    public function index(){
        parent::setDashboardType('expense');
        return parent::viewfilteredBySessionTime();
    }
}
