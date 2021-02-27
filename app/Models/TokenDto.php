<?php

namespace App\Models;

/**
 * @OA\Schema(
 *     title="TokenDto",
 *     schema="tokenDto"
 * )
 *
 */
class TokenDto
{
    /**
     * @OA\Property()
     * @var string
     */
    private $access_token;

    /**
     * @OA\Property()
     * @var string
     */
    private $token_type;

    /**
     * @OA\Property()
     * @var integer
     */
    private $expires_in;

    /**
     * @OA\Property()
     * @var User
     */
    private $user;
}
