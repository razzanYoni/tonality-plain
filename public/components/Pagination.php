<?php

function pagination($totalPage, $currentPage = 1) : string
{
    $uri = $_SERVER['REQUEST_URI'];

    if (!str_contains($uri, '?')) {
        if (!str_contains($uri, 'page=')) {
            $uri = $uri . '?page=' . $currentPage;
        } else {
            $uri .= '?page=' . $currentPage;
        }
    }

    $first = '';
    if ($currentPage > 1) {
        $first = '<a href="' . str_replace('page=' . $currentPage, 'page=1', $uri) . '" class="pagination-item">1</a>';
    }

    $prev = '';
    if ($currentPage > 2) {
        $prev = '<a href="' . str_replace('page=' . $currentPage, 'page=' . ($currentPage - 1), $uri) . '" class="pagination-item">Prev</a>';
    }

    $current = "<a href='" . str_replace('page=' . $currentPage, 'page=' . $currentPage, $uri) . "' class='pagination-item'>{$currentPage}</a>";

    $next = '';
    if ($currentPage < $totalPage - 1) {
        $next = '<a href="' . str_replace('page=' . $currentPage, 'page=' . ($currentPage + 1), $uri) . '" class="pagination-item">Next</a>';
    }

    $last = '';
    if ($currentPage < $totalPage) {
        $last = '<a href="' . str_replace('page=' . $currentPage, 'page=' . $totalPage, $uri) . '" class="pagination-item">Last</a>';
    }

    return <<<"EOT"
        <div class="pagination">
            $first
            $prev
            $current
            $next
            $last
        </div>
        
        EOT;
}