<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginationService
{
    public function paginate($query, $perPage, $page)
    {
        if (empty($perPage)) $perPage = 10;
        if (empty($page)) $page = 1;

        $paginator = $query->paginate($perPage, ['*'], 'page', $page);

        return [
            'data' => $paginator->items(),
            'meta' => $this->getMeta($paginator),
        ];
    }

    private function getMeta(LengthAwarePaginator $paginator)
    {
        return [
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'total' => $paginator->total(),
        ];
    }
}