<?php
require_once 'system/db.inc.php';
include_once 'frontend/php_includes/func.inc.php';

function getClubsOrSearch($searchQuery = null)
{
    if ($searchQuery) {
        return array_filter(
            getClubs(),
            fn($c) => stripos($c['name'], $searchQuery) !== false ||
                stripos($c['city'], $searchQuery) !== false ||
                stripos($c['province'], $searchQuery) !== false ||
                stripos($c['description'], $searchQuery) !== false
        );
    }
    return getClubs();
}

function pagination($sections, $sectionPerPage, $page = 1)
{
    $totalPages = ceil(count($sections) / $sectionPerPage);
    $sectionsToShow = array_slice($sections, ($page - 1) * $sectionPerPage, $sectionPerPage);

    return [
        'sectionsToShow' => $sectionsToShow,
        'totalPages' => $totalPages,
    ];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=3.0, user-scalable=yes">
    <title>WEBSITE HOMEPAGE</title>

    <!-- Facebook Meta Tags -->
<meta property="og:url" content="http://localhost:5173/frontend/">
<meta property="og:type" content="website">
<meta property="og:title" content="The Belgian Diamond">
<meta property="og:description" content="a list of all the Belgian baseball clubs from Belgium">
<meta property="og:image" content="../frontend/public/images/logo.png">

<meta name="keywords" content="Baseball, Belgian baseballClubs, master-detailpage,belgische baseballclubs, honkbal">
<meta name="robots" content="index, follow">

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
        $sections = getClubsOrSearch($_GET['search'] ?? null);
        $page = (int) ($_GET['page'] ?? 1);
        $sectionPerPage = (int) ($_GET['sectionPerPage'] ?? 4);

        $sortFields = ['name', 'city', 'province'];
        $sort = $_GET['sort'] ?? 'name';
        $sortDirection = $_GET['sortDirection'] ?? 'asc';

        usort($sections, fn($a, $b) => ($sortDirection === 'asc' ? 1 : -1) * strcmp($a[$sort], $b[$sort]));

        ['sectionsToShow' => $sectionsToShow, 'totalPages' => $totalPages] = pagination($sections, $sectionPerPage, $page);
        ?>
        <form action="/frontend/index.php" method="get">
            <h2>Search for clubs</h2>
            <input type="search" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <label for="sort">Sort by:</label>
            <select name="sort" id="sort">
                <?php foreach ($sortFields as $field): ?>
                    <option value="<?= $field ?>" <?= $sort === $field ? 'selected' : '' ?>><?= ucfirst($field) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="sortDirection">
                <option value="asc" <?= $sortDirection === 'asc' ? 'selected' : '' ?>>Ascending</option>
                <option value="desc" <?= $sortDirection === 'desc' ? 'selected' : '' ?>>Descending</option>
            </select>
            <label for="sectionPerPage">Sections per page:</label>
            <input type="number" name="sectionPerPage" value="<?= $sectionPerPage ?>" id="sectionPerPage" required>
            <button type="submit">Search</button>
        </form>
        <div class="club-container">
            <?php foreach ($sectionsToShow as $club): ?>
                <a href="/frontend/pages/detail.php?id=<?= (int) $club['id'] ?>">
                    <section style="background-image: url('<?= htmlspecialchars($club['logo_url']) ?>');">
                        <div class="content">
                            <h2><?= htmlspecialchars($club['name']) ?></h2>
                            <p><?= htmlspecialchars($club['zip']) ?> <?= htmlspecialchars($club['city']) ?>, <?= htmlspecialchars($club['province']) ?></p>
                            <p><?= htmlspecialchars($club['street']) ?> <?= htmlspecialchars($club['address']) ?> <?= htmlspecialchars($club['bus']) ?></p>
                            <p><?= htmlspecialchars(substr($club['description'], 0, 100)) ?>...</p>
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
                    <!-- Text indicating which sections are shown -->
                    <p>Showing <?= ($page - 1) * $sectionPerPage + 1 ?> to <?= min($page * $sectionPerPage, count($sections)) ?> of <?= count($sections) ?> clubs.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include('frontend/partials/footer.inc.php') ?>
</body>

</html>