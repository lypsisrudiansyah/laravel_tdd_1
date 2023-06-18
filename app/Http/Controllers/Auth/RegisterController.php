<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => 'Rudiansyah',
            'email' => 'rudi@mail.com',
            'password' => bcrypt('1234'),
        ]);

        return $user;
    }
}
