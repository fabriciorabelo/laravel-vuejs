<?php

namespace App\Models;

/**
 * @OA\Schema(
 *     title="ValidationDto",
 *     schema="validationDto"
 * )
 *
 */
class ValidationDto
{
    /**
     * @OA\Property()
     * @var string
     */
    private $errors;
}
