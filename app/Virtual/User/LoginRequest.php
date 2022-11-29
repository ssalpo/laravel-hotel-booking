<?php

namespace App\Virtual\User;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Login request"
 * )
 */
class LoginRequest
{
    /**
     * @OA\Property(
     *     title="email",
     *     nullable=false,
     *     example="user1@gmail.com"
     * )
     *
     * @var string
     */
    private $email;

    /**
     * @OA\Property(
     *     title="password",
     *     nullable=false,
     *     example="secret"
     * )
     *
     * @var string
     */
    private $password;
}
