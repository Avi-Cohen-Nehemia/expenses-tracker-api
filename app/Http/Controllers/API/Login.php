<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class Login extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'password' => ['required']
        ]);

        $user = User::where('name', $request->name)->first();

        if (!$user || $request->password !== $user->password) {
            throw ValidationException::withMessages([
                'error' => ["Incorrect username or password"]
            ]);
        }

        return response()->json([
            "id" => $user->id,
            "name" => $user->name,
            "access_token" => $user->createToken("Auth Token")->accessToken,
        ]);
    }
}
