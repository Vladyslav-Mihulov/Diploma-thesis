<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegistration()
    {
        return view('auth.registration');
    }



    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Invalid credentials'
            ]);
        }

        Auth::login($user);

        return redirect('/')->with('success', ['Login successful!']);
    }


    public function registration(RegisterRequest $request)
    {
        DB::beginTransaction();

        try {

            $user = User::create([
                'f_name' => $request->first_name,
                'l_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),

                'created_at' => now(),
                'modify_at' => now(),

                'created_by' => null,
                'modify_by' => null,
            ]);

            $user->update([
                'created_by' => $user->id,
                'modify_by' => $user->id,
            ]);

            $user->roles()->attach(1);

            DB::commit();

            Auth::login($user);

            return redirect('/login')->with('success', ['Registration successful!']);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login')->with('success', ['Logout successful!']);
    }
}
