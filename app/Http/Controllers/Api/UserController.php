<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Resources\UserResource;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    /**
     * Список всех пользователей
     *
     * @OA\Get(
     *     path="/api/users",
     *     security={{ "apiAuth": {} }},
     *     tags={"Users"},
     *     summary="Возвращает список всех пользователей",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/UserCollectionResource")
     *      )
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }

    /**
     * Список бронирований по ID пользователя
     *
     * @OA\Get(
     *     security={{ "apiAuth": {} }},
     *     path="/api/users/{user}/bookings",
     *     @OA\Parameter(
     *         in="query",
     *         name="limit",
     *         example="10",
     *         required=false,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="offset",
     *         example="1",
     *         required=false,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         in="query",
     *         name="status",
     *         required=false,
     *         example="1",
     *         description="1=CONFIRMED, 2=CANCELED, 3=RESERVED",
     *         @OA\Schema(type="string"),
     *     ),
     *     tags={"Users"},
     *     summary="Список бронирований по ID пользователя",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/BookingCollectionResource")
     *      )
     * )
     *
     * @param int $user
     * @return AnonymousResourceCollection
     */
    public function bookings(int $user): AnonymousResourceCollection
    {
        return BookingResource::collection(
            Booking::whereUserId($user)->with(['room', 'user'])
                ->userLimit()
                ->filter()
                ->get()
        );
    }
}
