<?php

namespace App\Http\Controllers;

class DashboardController extends MyController
{
    public function index()
    {
        return view('dashboard', $this->data);
    }
}
