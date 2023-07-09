<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function connectService(Request $request)
    {
        dd($request->service);
    }
}
