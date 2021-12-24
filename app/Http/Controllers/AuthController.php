<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ]);
    
        $user = User::where('username', $request->username)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function logout(Request $request){
        $user = User::where('username', $request->username)->first();

            if ($user){
                $user->tokens()->delete();
            }else{
                return "Data tidak ditemukan";
            }
            return "Anda berhasil logout!";
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => ['required','confirmed', Password::defaults()],
            'device_name' => 'required',
        ]);
    
       $user = User::create([
           'name' => $request-> name,
           'fullname' => $request ->fullname,
           'username' => $request ->username,
           'password' => Hash::make($request->password),
       ]);
    
        return $user->createToken($request->device_name)->plainTextToken;
    }
}
