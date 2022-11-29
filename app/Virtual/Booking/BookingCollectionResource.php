<?php

namespace App\Virtual\Booking;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(title="Booking collection resource")
 */
class BookingCollectionResource
{
    /**
     * @OA\Property(
     *     title="array",
     *     @OA\Items(ref="#/components/schemas/BookingResource")
     * )
     *
     * @var array
     */
    private $data;
}
