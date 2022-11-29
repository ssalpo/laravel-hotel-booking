<?php

namespace App\Virtual\Room;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(title="Room collection resource")
 */
class RoomCollectionResource
{
    /**
     * @OA\Property(
     *     title="array",
     *     @OA\Items(ref="#/components/schemas/RoomResource")
     * )
     *
     * @var array
     */
    private $data;
}
