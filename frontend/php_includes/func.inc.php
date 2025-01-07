<?php

// php functions
function sum($x, $y)
{
    return $x + $y;
}

function getClubsOrSearch($searchQuery = null)
{
    if ($searchQuery) {
        return array_filter(
            getClubs(),
            fn($c) => stripos($c['name'], $searchQuery) !== false ||
                stripos($c['city'], $searchQuery) !== false ||
                stripos($c['province'], $searchQuery) !== false
            // stripos($c['description'], $searchQuery) !== false
        );
    }
    return getClubs();
}

function pagination($clubs, $clubsPerPage, $page = 1)
{
    $totalPages = ceil(count($clubs) / $clubsPerPage);
    $clubsToShow = array_slice($clubs, ($page - 1) * $clubsPerPage, $clubsPerPage);

    return [
        'clubsToShow' => $clubsToShow,
        'totalPages' => $totalPages,
    ];
}
