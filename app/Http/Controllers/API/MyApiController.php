<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class MyApiController extends Controller
{
    protected array $data = [];

    public function __construct()
    {
        $this->middleware('api.token');
    }
}
