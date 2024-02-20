<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate the data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //get credentials from requets
        $credentials = $request->only('email', 'password');
        
        //check the remeber is selected or not filled return true if checked
        $remember = $request->filled('remember');

         //fetch the data from database correspondence to this email
        $user = User::where('email' , '=', $credentials['email'])->first();

        //This will authenticate the user
        if(Auth::attempt($credentials,$remember)){
            return redirect()->intended('/');
        }else{
            // throw ValidationException::withMessages([
            //     'error' => 'The provided credentials are incorrect'
            // ]);

            return redirect()->back()->with('error', 'The provided credentials are incorrect');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();

        //destroy the session
        request()->session()->invalidate();

        //regenrate the seesion token for csrf
        request()->session()->regenerateToken();

        return redirect('/');

    }
}
