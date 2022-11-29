<?php

namespace App\Virtual\Booking;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Booking request"
 * )
 */
class BookingRequest
{
    /**
     * @OA\Property(
     *     title="room_id",
     *     nullable=false
     * )
     *
     * @var int
     */
    private $room_id;

    /**
     * @OA\Property(
     *     title="user_id",
     *     nullable=true
     * )
     *
     * @var int
     */
    private $user_id;

    /**
     * @OA\Property(
     *     title="check_in",
     *     nullable=false
     * )
     *
     * @var date
     */
    private $check_in;
}
