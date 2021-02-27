<?php

namespace App\Models;

/**
 * @OA\Schema(
 *     title="RegisterDto",
 *     schema="registerDto"
 * )
 *
 */
class RegisterDto extends UserDto
{
    /**
     * @OA\Property()
     * @var string
     */
    private $password_confirmation;
}
