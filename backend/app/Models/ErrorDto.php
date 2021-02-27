<?php

namespace App\Models;

/**
 * @OA\Schema(
 *     title="ErrorDto",
 *     schema="errorDto"
 * )
 *
 */
class ErrorDto
{
    /**
     * @OA\Property()
     * @var string
     */
    private $message;
}
