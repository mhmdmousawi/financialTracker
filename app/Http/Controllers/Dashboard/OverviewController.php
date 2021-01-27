<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Http\Request;

class OverviewController extends DashboardController
{
    public function index(){
        parent::setDashboardType('overview');
        return parent::viewfilteredBySessionTime();
    }
}