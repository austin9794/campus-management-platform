<?php
namespace App\Helpers;

class PaginationHelper {
    public static function paginate(int $total, int $perPage, int $currentPage): array {
        $totalPages  = (int) ceil($total / $perPage);
        $currentPage = max(1, min($currentPage, $totalPages));
        $offset      = ($currentPage - 1) * $perPage;
        return [
            'total'        => $total,
            'per_page'     => $perPage,
            'current_page' => $currentPage,
            'total_pages'  => $totalPages,
            'offset'       => $offset,
            'has_prev'     => $currentPage > 1,
            'has_next'     => $currentPage < $totalPages,
            'prev_page'    => $currentPage - 1,
            'next_page'    => $currentPage + 1,
        ];
    }
}
