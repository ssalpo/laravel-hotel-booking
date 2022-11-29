<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

class RoomController extends Controller
{
    /**
     * Список номеров
     *
     * @OA\Get(
     *     path="/api/rooms",
     *     security={{ "apiAuth": {} }},
     *     tags={"Rooms"},
     *     summary="Возвращает список всех номеров",
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/RoomCollectionResource")
     *      )
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return RoomResource::collection(
            Room::all()
        );
    }
}
