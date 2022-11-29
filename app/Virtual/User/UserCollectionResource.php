<?php

namespace App\Virtual\User;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(title="Room collection resource")
 */
class UserCollectionResource
{
    /**
     * @OA\Property(
     *     title="array",
     *     @OA\Items(ref="#/components/schemas/UserResource")
     * )
     *
     * @var array
     */
    private $data;
}
