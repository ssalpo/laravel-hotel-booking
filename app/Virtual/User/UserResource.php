<?php

namespace App\Virtual\User;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="User resource"
 * )
 */
class UserResource
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
     *     title="name",
     *     nullable=false
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *     title="email",
     *     nullable=false
     * )
     *
     * @var string
     */
    private $email;
}
