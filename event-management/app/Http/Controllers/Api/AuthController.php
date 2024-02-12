<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //login method
    public function login(Request $request){
        //first validate the email and password
        $request->validate([
            'email' => 'required|email', //email is required and it sould be email
            'password' => 'required' //Password must be there
        ]);

        //fetch the data from database correspondence to this email
        $user = \App\Models\User::where('email', $request->email)->first(); //fetch first data for this email

        //check wheaher user exist or not if not then throw validation error
        if(!$user){
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        //Check the password provided is correct or not using hash check
        if(!Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        //Now user is geniun so genrate a token for that
        $token = $user->createToken('api-token')->plainTextToken; //using traits HasApiTokens which use in User model will create token and corvert it into plainText

        //send response in Json
        return response()->json([
            'token' => $token
        ]);

    }

    //logout method
    public function logout(Request $request){

        //delete token to logout
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);

    }
}
