<?php

require_once 'system/db.inc.php';
include_once 'frontend/php_includes/func.inc.php';

$clubs = getClubsOrSearch(isset($_GET['search']) ? $_GET['search'] : null);
$page = (int) ($_GET['page'] ?? 1);
$clubsPerPage = (int) ($_GET['clubsPerPage'] ?? 4);

$sortFields = ['name', 'city', 'province'];
$sort = $_GET['sort'] ?? 'name';
$sortDirection = $_GET['sortDirection'] ?? 'asc';

usort($clubs, fn($a, $b) => ($sortDirection === 'asc' ? 1 : -1) * strcmp($a[$sort], $b[$sort]));

['clubsToShow' => $clubsToShow, 'totalPages' => $totalPages] = pagination($clubs, $clubsPerPage, $page);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=3.0, user-scalable=yes">
    <title>WEBSITE HOMEPAGE</title>

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="https://thebelgiandiamond.infinityfreeapp.com">
    <meta property="og:type" content="website">
    <meta property="og:title" content="The Belgian Diamond">
    <meta property="og:description" content="a list of all the Belgian baseball clubs from Belgium">
    <meta property="og:image" content="/frontend/images/logo.png">

    <meta name="keywords" content="Baseball, Belgian baseballClubs, master-detailpage,belgische baseballclubs, honkbal">
    <meta name="robots" content="index, follow">

    <link rel="stylesheet" href="/frontend/css/index.css" />
    <script src="/frontend/js/index.js" defer type="module"></script>
    <script type="module" src="/frontend/js/advanced-search.js" defer></script>
    <link rel="icon" type="image/png" href="/frontend/images/logo_trimmed.png" />
    <style>
        .club-container {
            max-width: <?= count($clubsToShow) * (300 + 40) ?>px;
        }

        <?php if (empty($clubsToShow)):
        ?>#advanced-search {
            visibility: hidden;
            position: absolute;
            display: block;
        }

        .advanced-search-toggle {
            display: none;
        }

        <?php endif ?>
    </style>
</head>

<body>
    <?php include('frontend/partials/header.inc.php') ?>
    <main>
        <div class="container">
            <form action="/" method="get">
                <h2>Search for clubs</h2>
                <label for="search">Name/City/Province:</label>
                <input type="search" name="search" value="<?= $_GET['search'] ?? '' ?>" minlength="3">
                <div id="advanced-search">
                    <label for="sort">Sort by:</label>
                    <select name="sort">
                        <?php foreach ($sortFields as $field): ?>
                            <?php $sortSelected = $sort === $field ? 'selected' : ''  ?>
                            <?php $fieldName = ucfirst($field) ?>
                            <?= "<option value='$field' $sort > $fieldName </option>" ?>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="sortDirection" value="<?= $sortDirection ?>">
                    <button type="button" class="toggleSortDirection">
                        <?= $sortDirection === 'asc' ? '↑ Ascending' : '↓ Descending' ?>
                    </button>
                    <label for="clubsPerPage">Clubs per page:</label>
                    <input type="range" name="clubsPerPage" class="clubsPerPageSlider" value="<?= $clubsPerPage ?>" min="1" max="<?= max($clubsPerPage, count($clubs)) ?>">
                    <span id="clubsPerPageValue"><?= $clubsPerPage ?></span>
                </div>
                <button type="submit">Search</button>
                <?php if (empty($clubsToShow)): ?>
                    <p class="error">No clubs found, please try again with different search terms.</p>
                <?php else: ?>
                    <i class="advanced-search-toggle fa-solid fa-chevron-down"></i>
                <?php endif; ?>
            </form>
            <div class="club-container">
                <div>
                    <?php foreach ($clubsToShow as $club): ?>
                        <a href="/club/<?= (int) $club['id'] ?>">
                            <article>
                                <div>
                                    <img src="<?= $club['logo_url'] ?>" alt="<?= $club['name'] ?> logo">
                                </div>
                                <div class="content">
                                    <h2><?= $club['name'] ?></h2>
                                    <p><?= $club['city'] ?>, <?= $club['province'] ?></p>
                                    <p><?= mb_strimwidth($club['description'], 0, 150, '...') ?></p>
                                </div>
                            </article>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <!-- Link to go to the first page -->
                        <a href="?<?= http_build_query(array_merge($_GET, ['page' => 1])) ?>">|&lt;</a>
                    <?php endif; ?>
                    <?php if ($page > 1): ?>
                        <!-- Link to go to the previous page -->
                        <a href="?<?= http_build_query(array_merge($_GET, ['page' => max(1, $page - 1)])) ?>">&lt;</a>
                    <?php endif; ?>
                    <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                        <!-- Link to go to a specific page -->
                        <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" class="page-<?= $i ?><?= $i == $page ? ' active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <!-- Link to go to the next page -->
                        <a href="?<?= http_build_query(array_merge($_GET, ['page' => min($totalPages, $page + 1)])) ?>">&gt;</a>
                    <?php endif; ?>
                    <?php if ($page < $totalPages): ?>
                        <!-- Link to go to the last page -->
                        <a href="?<?= http_build_query(array_merge($_GET, ['page' => $totalPages])) ?>">&gt;|</a>
                    <?php endif; ?>
                    <?php if ($totalPages > 1): ?>
                        <!-- Text indicating which clubs are shown -->
                        <p>Showing <?= ($page - 1) * $clubsPerPage + 1 ?> to <?= min($page * $clubsPerPage, count($clubs)) ?> of <?= count($clubs) ?> clubs</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
    <?php include('frontend/partials/footer.inc.php') ?>
</body>

</html>