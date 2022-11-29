<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Авторизация
     *
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     summary="Авторизация",
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Запрос обработан"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Ошибка проверки данных пользователя"
     *     ),
     *     @OA\Response(
     *         response="419",
     *         description="Ошибка валидации"
     *     ),
     * )
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!$token = auth()->attempt($request->validated())) {
            return response()->json(['error' => 'Некорректные данные переданы.'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Производит выход из системы
     *
     * @OA\Post(
     *     security={{ "apiAuth": {} }},
     *     path="/api/auth/logout",
     *     tags={"Auth"},
     *     summary="Производит выход из системы",
     *     @OA\Response(
     *         response="201",
     *         description="Запрос обработан"
     *     ),
     * )
     *
     * @return void
     */
    public function logout(): void
    {
        auth()->logout();
    }

    /**
     * Возвращает обновленный токен
     *
     * @OA\Post(
     *     security={{ "apiAuth": {} }},
     *     path="/api/auth/refresh",
     *     tags={"Auth"},
     *     summary="Возвращает обновленный токен",
     *     @OA\Response(
     *         response="201",
     *         description="Запрос обработан"
     *     ),
     * )
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Возвращает данные профиля
     *
     * @OA\Get(
     *     security={{ "apiAuth": {} }},
     *     path="/api/auth/profile",
     *     tags={"Auth"},
     *     summary="Возвращает данные профиля",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
     *      )
     * )
     *
     * @return UserResource
     */
    public function profile(): UserResource
    {
        return UserResource::make(auth()->user());
    }

    /**
     * Возвращает структуру jwt
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function createNewToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
