<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepository implements AuthRepositoryInterface
{
    public function login(array $credentials)
    {
        if (! $token = auth()->attempt($credentials)) {
            return false;
        }

        return $token;
    }

    public function register(array $data)
    {
       $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

        $token = auth()->login($user);
        $ttl = JWTAuth::factory()->getTTL();

        return [
        'message' => '!Usuario registrado exitosamente!',
        'user' => $user,
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => $ttl * 1000,
    ];
    }

    public function logout()
    {
        auth()->logout();
    }

    public function refresh()
    {
        return auth()->refresh();
    }

    public function getUser()
    {
        return auth()->user();
    }

}
