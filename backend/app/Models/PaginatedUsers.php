<?php

namespace App\Models;

/**
 * @OA\Schema(
 *     title="PaginatedUsers",
 *     schema="paginatedUsers"
 * )
 *
 */
class PaginatedUsers extends Paginated
{
    /**
     * @OA\Property(
     *     @OA\Items(ref="#/components/schemas/user")
     * )
     * @var array User
     */
    public $list;

    public function __construct($model, $per_page = 100)
    {
        if (!$per_page || $per_page > 100) {
            $per_page = 100;
        }

        $paginated = $model->paginate($per_page);

        $current_page = $paginated->currentPage() + 1;
        $next_page = $current_page > $paginated->lastPage() ? $paginated->lastPage() : $current_page;

        $this->page = $paginated->currentPage();
        $this->next_page = $next_page;
        $this->first_page = $paginated->firstItem() ? $paginated->firstItem() : 0;
        $this->last_page = $paginated->lastPage();
        $this->per_page = $paginated->perPage();
        $this->total = $paginated->total();

        $this->list = $paginated->items();
    }
}
