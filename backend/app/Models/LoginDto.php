<?php

namespace App\Models;

/**
 * @OA\Schema(
 *     title="LoginDto",
 *     schema="loginDto"
 * )
 *
 */
class LoginDto
{
    /**
     * @OA\Property()
     * @var string
     */
    private $email;

    /**
     * @OA\Property()
     * @var string
     */
    private $password;
}
