<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\Interfaces\AuthRepositoryInterface;



/**
 * @OA\Tag(
 *     name="Autenticación",
 *     description="Endpoints de autenticación para el inicio y cierre de sesión y registro y obneter información del usuarrio autenticado, "
 * )
 */

 /**
 * @OA\Info(
 *     title="API Prueba Soluciones Fourgen",
 *     version="1.0",
 *     description="API para la prueba técnica de Soluciones Fourgen, donde se podran verificar los diferentes endpoints relacionados con la autenticación, manejo de personas y sus mascotas"
 * )
 *
 * @OA\Server(
 *     url="http://prueba-soluciones-fourgen.test"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */

class AuthController extends Controller
{
    protected $authRepo;

    public function __construct(AuthRepositoryInterface $authRepo)
    {
        $this->middleware('jwt.verify', ['except' => ['login', 'register']]);
        $this->authRepo = $authRepo;
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Iniciar sesión y obtener token de autenticación",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="usuario@correo.com"),
     *             @OA\Property(property="password", type="string", format="password", example="claveSecreta123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="¡Inicio de sesión exitoso!"),
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $token = $this->authRepo->login($credentials);

        if (! $token) {
            return response()->json(['error' => 'Sin autorización, El email o el Password son incorrectos'], 401);
        }

        return $this->respondWithToken($token);
    }

        /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registrar un nuevo usuario",
     *     tags={"Autenticación"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="email", type="string", format="email", example="juan@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario registrado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario registrado exitosamente"),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="email", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos inválidos"
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {
        //validar el request
        $data = $request->validated();
        $result = $this->authRepo->register($data);

        return response()->json($result, 201);
    }


        /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Obtener información del usuario autenticado",
     *     tags={"Autenticación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Información del usuario",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="email", type="string", example="juan@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     )
     * )
     */
    public function getInfoUser()
    {
        return response()->json($this->authRepo->getUser());
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Cerrar sesión del usuario autenticado",
     *     tags={"Autenticación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Cierre de sesión exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="¡Has cerrado sesión exitosamente!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Token inválido o no autenticado"
     *     )
     * )
     */
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
