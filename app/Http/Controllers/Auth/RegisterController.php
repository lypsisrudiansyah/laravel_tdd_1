<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $dataInput = $request->validated();
        $dataInput['password'] = bcrypt($request->password);

        $user = User::create($dataInput);

        return $user;
    }
}
