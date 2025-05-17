<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\Interfaces\AuthRepositoryInterface;


class AuthController extends Controller
{
    protected $authRepo;

    public function __construct(AuthRepositoryInterface $authRepo)
    {
        $this->middleware('jwt.verify', ['except' => ['login','register']]);
        $this->authRepo = $authRepo;
    }

    
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $token = $this->authRepo->login($credentials);

        if (! $token) {
            return response()->json(['error' => 'Sin autorización, El email o el Password son incorrectos'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request)
    {
        //validar el request
        $data = $request->validated();
        $result = $this->authRepo->register($data);

        return response()->json($result, 201);

    }


    public function getInfoUser()
    {
        return response()->json($this->authRepo->getUser());
    }


    public function logout()
    {
        $this->authRepo->logout();
        return response()->json(['message' => '¡Has cerrado sesión exitosamente!']);
    }


    public function refresh()
    {
        return $this->respondWithToken($this->authRepo->refresh());
    }


    protected function respondWithToken($token)
    {
        $ttl = JWTAuth::factory()->getTTL();

        return response()->json([
            'message' => '¡Inicio de sesión exitoso!',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl * 1000
        ]);
    }
}