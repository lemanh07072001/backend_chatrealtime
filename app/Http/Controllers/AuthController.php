<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegiaterRequest;

class AuthController extends Controller
{
    public function register(RegiaterRequest $request){

        try{
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đăng nhập thành công.'
            ], 201);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function login(LoginRequest $request){

        try{
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $token = $request->user()->createToken('auth');
                return response()->json([
                    'success' => true,
                    'token' => $token,
                    'message' => "Đăng nhập thành công!"
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Tài khoản hoặc mật khẩu không chính xác'
            ], 401);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function profile(Request $request){
        return response()->json([
            'success' => true,
            'user' => $request->user()
        ],200);
    }
}
