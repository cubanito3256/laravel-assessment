<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function login(Request $request){
        
        // email and password are required, and enforces email structure
        $request->validate([
            'email' => ['email', 'required'],
            'password' => ['required'],
        ]);

        // if username does not exists or password is incorrect, returns an error message
        if ((!$user = \App\User::where('email', $request->email)->first()) || !Hash::check($request->password, $user->password)){
            abort(401, "User or password incorrect");
        }

        // if the user is disabled...
        if (!$user->enabled){
            abort(403, "User is disabled");
        }

        // generates and returns a user access token
        return $user->createToken('Auth Token')->accessToken;
    }

    public function register(Request $request){
        // email and password are required, and enforces email structure
        $request->validate([
            'email' => ['email', 'required'],
            'password' => ['required'],
        ]);

        // if email already exists, returns an error
        if (\App\User::where('email', $request->email)->first()){
            throw ValidationException::withMessages([
                'email' => ['The email provided already exists']
            ]);
        }

        // sets the data for the new user
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
        ];

        // creates the user
        \App\User::create($data);
    }
}
