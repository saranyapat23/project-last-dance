<?php
function renderPagination(int $currentPage, int $totalItems, int $perPage, string $baseUrl = '?page=') 
{
    $totalPages = ceil($totalItems / $perPage);
    if ($totalPages <= 1) return;

    echo '<div style="text-align:center; margin-top:20px;">';
    if ($currentPage > 1) {
        echo '<a href="' . $baseUrl . ($currentPage - 1) . '">⬅ ก่อนหน้า</a> ';
    }

    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i === $currentPage) {
            echo '<strong>' . $i . '</strong> ';
        } else {
            echo '<a href="' . $baseUrl . $i . '">' . $i . '</a> ';
        }
    }

    if ($currentPage < $totalPages) {
        echo '<a href="' . $baseUrl . ($currentPage + 1) . '">ถัดไป ➞</a>';
    }
    echo '</div>';
}
