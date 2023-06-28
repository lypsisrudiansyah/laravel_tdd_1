<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('lypsis-auth');

        // Log::info($token);
        return response([
            'token' => $token->plainTextToken,
        ], 200);
    }

    /* public function asb()
    {
        $user = Auth::user();
        // $currentAccessToken = $user->currentAccessToken();

        return response()->json($user);
        
    } */
}
