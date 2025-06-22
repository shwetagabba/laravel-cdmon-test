<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $request=>Validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255|unique:users',
            'password'=>'required|string|min:6|confirmed',
        ]);

        $users=User::create([
            'name'=> $request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);

        $token=$user->CreateToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token'=>$token,
            'token_type'=>'Bearer',
        ], 201);

           
    }
    public function login(Request $request){
     
     if(Auth::attempt($request->only('email','password'))){
        return response()->json([
            'message'=>"Invalid Login details"
        ]);
     }

    }
    public function user(Request $request){
        return response()->json($request->user());

    }
    public function logout(Request $request){
        
        $request->user()->token()->delete();
        return response()->json([
            'message'=>"Logged out"
        ]);
    }
}
