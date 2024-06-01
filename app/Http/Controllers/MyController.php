<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MyController extends Controller
{
    protected array $data = [];

    public function __construct()
    {
        $this->middleware('auth');
    }
}
