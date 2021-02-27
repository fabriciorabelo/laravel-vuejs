<?php

namespace App\Models;

/**
 * @OA\Schema(
 *     title="UserDto",
 *     schema="userDto"
 * )
 *
 */
class UserDto
{
    /**
     * @OA\Property()
     * @var string
     */
    private $name;

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
