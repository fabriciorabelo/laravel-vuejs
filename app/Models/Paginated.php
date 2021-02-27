<?php

namespace App\Models;

class Paginated
{
    /**
     * @OA\Property()
     * @var integer
     */
    public $page;

    /**
     * @OA\Property()
     * @var integer
     */
    public $next_page;

    /**
     * @OA\Property()
     * @var integer
     */
    public $first_page;


    /**
     * @OA\Property()
     * @var integer
     */
    public $last_page;

    /**
     * @OA\Property()
     * @var integer
     */
    public $per_page;

    /**
     * @OA\Property()
     * @var integer
     */
    public $total;
}
