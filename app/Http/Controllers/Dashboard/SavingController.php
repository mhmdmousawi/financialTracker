<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Http\Request;

class SavingController extends DashboardController
{
    public function index(){
        parent::setDashboardType('saving');
        return parent::viewfilteredBySessionTime();
    }
}
