<?php
require_once 'system/db.inc.php';
include_once 'frontend/php_includes/func.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEBSITE HOMEPAGE</title>
    <link rel="stylesheet" href="/frontend/css/style.css" />
    <script src="/frontend/js/script.js" defer type="module"></script>
    <link rel="icon" type="image/png" href="/frontend/images/logo.png" />
</head>

<body>
    <?php include('frontend/partials/header.inc.php') ?>
    <main>
        <header>
            <p>BANNER - Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
        </header>
        <?php
        $clubs = getClubsOrSearch(isset($_GET['search']) ? $_GET['search'] : null);
        $page = (int) ($_GET['page'] ?? 1);
        $clubsPerPage = (int) ($_GET['clubsPerPage'] ?? 4);

        $sortFields = ['name', 'city', 'province'];
        $sort = $_GET['sort'] ?? 'name';
        $sortDirection = $_GET['sortDirection'] ?? 'asc';

        usort($clubs, fn($a, $b) => ($sortDirection === 'asc' ? 1 : -1) * strcmp($a[$sort], $b[$sort]));

        ['clubsToShow' => $clubsToShow, 'totalPages' => $totalPages] = pagination($clubs, $clubsPerPage, $page);
        ?>
        <form action="/frontend/index.php" method="get">
            <h2>Search for clubs</h2>
            <label for="search">Name/City/Province:</label>
            <input type="search" name="search" value="<?= $_GET['search'] ?? '' ?>" minlength="3">
            <?php if (!empty($clubsToShow) && $totalPages > 1): ?>
                <label for="sort">Sort by:</label>
                <select name="sort">
                    <?php foreach ($sortFields as $field): ?>
                        <option value="<?= $field ?>" <?= $sort === $field ? 'selected' : '' ?>><?= ucfirst($field) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="sortDirection" value="<?= $sortDirection ?>">
                <button type="button" class="toggleSortDirection">
                    <?= $sortDirection === 'asc' ? '↑ Ascending' : '↓ Descending' ?>
                </button>
                <label for="clubsPerPage">Clubs per page:</label>
                <input type="range" name="clubsPerPage" class="clubsPerPageSlider" value="<?= $clubsPerPage ?>" min="1" max="<?= count($clubs) ?>">
                <span id="clubsPerPageValue"><?= $clubsPerPage ?></span>
            <?php endif; ?>
            <button type="submit">Search</button>
            <?php if (empty($clubsToShow)): ?>
                <p class="error">No clubs found, please try again with different search terms.</p>
            <?php endif; ?>
        </form>
        <div class="club-container">
            <?php foreach ($clubsToShow as $club): ?>
                <a href="/frontend/pages/detail.php?id=<?= (int) $club['id'] ?>">
                    <section>
                        <img src="<?= $club['logo_url'] ?>" alt="">
                        <div class="content">
                            <h2><?= $club['name'] ?></h2>
                            <p><?= $club['city'] ?>, <?= $club['province'] ?></p>
                            <p><?= mb_strimwidth($club['description'], 0, 150, '...') ?></p>
                        </div>
                    </section>
                </a>
            <?php endforeach; ?>
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
    </main>
    <?php include('frontend/partials/footer.inc.php') ?>
</body>

</html>