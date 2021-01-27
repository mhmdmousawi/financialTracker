<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Http\Request;


class IncomeController extends DashboardController
{
    public function index(){
        parent::setDashboardType('income');
        return parent::viewfilteredBySessionTime();
    }
}
