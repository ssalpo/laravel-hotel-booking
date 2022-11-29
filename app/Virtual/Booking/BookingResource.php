<?php

namespace App\Virtual\Booking;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Booking resource"
 * )
 */
class BookingResource
{
    /**
     * @OA\Property(
     *     title="id"
     * )
     *
     * @var int
     */
    private $id;

    /**
     * @OA\Property(
     *     title="room",
     *     nullable=false,
     *     @OA\Schema(ref="#/components/schemas/RoomResource")
     * )
     *
     * @var string
     */
    private $room;

    /**
     * @OA\Property(
     *     title="user",
     *     nullable=true,
     *     @OA\Schema(ref="#/components/schemas/UserResource")
     * )
     *
     * @var string
     */
    private $user;

    /**
     * @OA\Property(
     *     title="check_in",
     *     nullable=false
     * )
     *
     * @var date
     */
    private $check_in;

    /**
     * @OA\Property(
     *     title="status",
     *     nullable=false
     * )
     *
     * @var int
     */
    private $status;

    /**
     * @OA\Property(
     *     title="created_at",
     *     nullable=false
     * )
     *
     * @var date
     */
    private $created_at;

}
