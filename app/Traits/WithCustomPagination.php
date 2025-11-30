<?php

namespace App\Traits;

trait WithCustomPagination
{
    /**
     * Create a limited page range for pagination
     */
    public function getPageRange($paginator, $around = 2)
{
    $current = $paginator->currentPage();
    $last = $paginator->lastPage();

    $start = max($current - $around, 1);
    $end = min($current + $around, $last);

    return range($start, $end);
}

}
