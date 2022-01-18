<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha_num',
            'email' => 'required|email|unique:App\Models\User,email',
            'password' => 'required'
        ]);

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        $token = $user->createToken('secret')->plainTextToken;

        return response()->json([
            'access-token' => $token,
            'token-type' => 'Bearer'
        ]);
    }

    public function login(Request $request)
    {
        if(Auth::attempt($request->only('email', 'password'))){
            $user = User::where('email', $request->email)->firstOrFail();

            $token = $user->createToken('secret')->plainTextToken;

            return response()->json([
                'access-token' => $token,
                'token-type' => 'Bearer'
            ]);
        }
        return;
    }

    public function show(Request $request)
    {
        return $request->user();
    }
}
