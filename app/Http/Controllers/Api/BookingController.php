<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\ChangeBookingStatusRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

class BookingController extends Controller
{
    /**
     * Возвращает список всех бронирований
     *
     * @OA\Get(
     *     path="/api/bookings",
     *     security={{ "apiAuth": {} }},
     *     tags={"Bookings"},
     *     summary="Возвращает список всех бронирований",
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
     *         description="1=CONFIRMED, 2=CANCELED, 3=RESERVED",
     *         example="1",
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/BookingCollectionResource")
     *      )
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return BookingResource::collection(
            Booking::with(['room', 'user'])
                ->userLimit()
                ->filter()
                ->get()
        );
    }

    /**
     * Создает новую бронь
     *
     * @OA\Post(
     *     path="/api/bookings",
     *     security={{ "apiAuth": {} }},
     *     tags={"Bookings"},
     *     summary="Создает новую бронь",
     *      @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/BookingRequest")
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/BookingResource")
     *     ),
     *     @OA\Response(
     *         response=419,
     *         description="Validation error"
     *     )
     * )
     *
     * @param BookingRequest $request
     * @return BookingResource
     */
    public function store(BookingRequest $request): BookingResource
    {
        $booking = Booking::create($request->validated());

        return BookingResource::make(
            $booking->load(['room', 'user'])
        );
    }

    /**
     * Получает бронь по ID
     *
     * @OA\Get(
     *     path="/api/bookings/{booking}",
     *     security={{ "apiAuth": {} }},
     *     tags={"Bookings"},
     *     summary="Получает бронь по ID",
     *     @OA\Parameter(
     *         in="path",
     *         name="booking",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/BookingResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Брон не найдена"
     *     )
     * )
     * @param Booking $booking
     * @return BookingResource
     */
    public function show(Booking $booking): BookingResource
    {
        return BookingResource::make(
            $booking->load(['room', 'user'])
        );
    }

    /**
     * Обновляет бронь
     *
     * @OA\Put(
     *     path="/api/bookings/{booking}",
     *     security={{ "apiAuth": {} }},
     *     tags={"Bookings"},
     *     summary="Обновляет бронь",
     *     @OA\Parameter(
     *         in="path",
     *         name="booking",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\RequestBody(
     *        @OA\JsonContent(ref="#/components/schemas/BookingRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/BookingResource")
     *     )
     * )
     *
     * @param BookingRequest $request
     * @param Booking $booking
     * @return BookingResource
     */
    public function update(BookingRequest $request, Booking $booking): BookingResource
    {
        $booking->load(['room', 'user']);

        $booking->update($request->validated());

        return BookingResource::make($booking);
    }

    /**
     * Удаляет бронь
     *
     * @OA\Delete(
     *     path="/api/bookings/{booking}",
     *     security={{ "apiAuth": {} }},
     *     tags={"Bookings"},
     *     summary="Удаляет бронь",
     *     @OA\Parameter(
     *         in="path",
     *         name="booking",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     * @param Booking $booking
     * @return void
     */
    public function destroy(Booking $booking): void
    {
        $booking->delete();
    }

    /**
     * Меняет статус бронирования
     *
     * @OA\Post(
     *     path="/api/bookings/{booking}/change-status",
     *     security={{ "apiAuth": {} }},
     *     tags={"Bookings"},
     *     summary="Меняет статус бронирования",
     *     @OA\Parameter(
     *         in="path",
     *         name="booking",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\RequestBody(
     *        @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="status",
     *                type="string",
     *                required={"status"},
     *                example="2",
     *                description="1=CONFIRMED, 2=CANCELED, 3=RESERVED",
     *             ),
     *        ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="OK",
     *         @OA\JsonContent(ref="#/components/schemas/BookingResource")
     *     ),
     *     @OA\Response(
     *         response="419",
     *         description="Ошибка валидации"
     *     )
     * )
     *
     * @param Booking $booking
     * @param ChangeBookingStatusRequest $request
     * @return BookingResource
     */
    public function changeStatus(Booking $booking, ChangeBookingStatusRequest $request): BookingResource
    {
        $booking->load(['room', 'user']);

        $booking->update($request->validated());

        return BookingResource::make($booking->refresh());
    }
}
