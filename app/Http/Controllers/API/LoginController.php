<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    public function login(LoginRequest $request)
    {
        $credentials = request()->only(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json(['message' => 'Unauthorized'], 401);

        $user = $request->user();

        $token = $user->createToken('Personal Access Token');

        return response()->json([
            'user_id' => $user->id,
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString()
        ]);

    }


}
