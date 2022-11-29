<?php

namespace App\Virtual\Room;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Room resource"
 * )
 */
class RoomResource
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
     *     title="number",
     *     nullable=false
     * )
     *
     * @var int
     */
    private $number;

    /**
     * @OA\Property(
     *     title="price_per_night",
     *     nullable=false
     * )
     *
     * @var int
     */
    private $price_per_night;
}
