<?php
require_once 'system/db.inc.php';
include_once 'frontend/php_includes/func.inc.php';

function getClubsOrSearch($searchQuery = null)
{
    // If a search query is provided, filter clubs by name
    if ($searchQuery) {
        return array_filter(getClubs(), fn($c) => stripos($c['name'], $searchQuery) !== false);
    }
    // Return all clubs if no search query is provided
    return getClubs();
}

function pagination($sections, $sectionPerPage, $page = 1)
{
    // Calculate total number of sections and pages
    $totalSections = count($sections);
    $totalPages = ceil($totalSections / $sectionPerPage);

    // Get sections to display on the current page
    $sectionsToShow = array_slice($sections, ($page - 1) * $sectionPerPage, $sectionPerPage);

    // Return the sections to show and the total number of pages
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEBSITE HOMEPAGE</title>
    <link rel="stylesheet" href="/frontend/css/style.css" />
    <script src="/frontend/js/script.js" defer type="module"></script>
</head>

<body>
    <?php include('frontend/partials/header.inc.php') ?>
    <main>
        <header>
            <p>BANNER - Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis harum quibusdam, accusantium magnam sapiente mollitia quae dicta, dolore consequuntur incidunt modi excepturi quod expedita saepe ipsa autem repellat suscipit nisi!</p>
        </header>
        <!-- sections -->
        <?php
        $sections = getClubsOrSearch($_GET['search'] ?? null);
        $page = (int) ($_GET['page'] ?? 1);
        $sectionPerPage = 4;
        list('sectionsToShow' => $sectionsToShow, 'totalPages' => $totalPages) = pagination($sections, $sectionPerPage, $page);
        ?>
        <form action="/frontend/index.php" method="get">
            <input type="search" id="search" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit">Search</button>
        </form>
        <div class="club-container">
            <?php foreach ($sectionsToShow as $club) : ?>
                <a href="/frontend/pages/detail.php?id=<?= (int) $club['id'] ?>">
                    <section style="background-image: url('<?= htmlspecialchars($club['logo_url']) ?>');">
                        <div class="content">
                            <h2><?= htmlspecialchars($club['name']) ?></h2>
                            <p><?= htmlspecialchars($club['description']) ?></p>
                        </div>
                    </section>
                </a>
            <?php endforeach; ?>
            <!-- pagination -->
            <div class="pagination">
                <!-- Link to the first page, disabled if the current page is the first -->
                <a href="?page=1" class="first<?= $page <= 1 ? ' disabled' : '' ?>">|&lt;</a>

                <!-- Link to the previous page, disabled if the current page is the first -->
                <a href="?page=<?= max(1, $page - 1) ?>" class="prev<?= $page <= 1 ? ' disabled' : '' ?>">&lt;</a>

                <!-- Page number links, show 3 pages around the current one -->
                <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++) : ?>
                    <!-- Highlight the current page -->
                    <a href="?page=<?= $i ?>" class="page-<?= $i ?><?= $i == $page ? ' active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>

                <!-- Link to the next page, disabled if the current page is the last -->
                <a href="?page=<?= min($totalPages, $page + 1) ?>" class="next<?= $page >= $totalPages ? ' disabled' : '' ?>">&gt;</a>

                <!-- Link to the last page, disabled if the current page is the last -->
                <a href="?page=<?= $totalPages ?>" class="last<?= $page >= $totalPages ? ' disabled' : '' ?>">&gt;|</a>

                <!-- Display the range of clubs currently shown and the total number of clubs -->
                <?php if ($totalPages > 1) : ?>
                    <p>Showing <?= ($page - 1) * $sectionPerPage + 1 ?> to <?= min($page * $sectionPerPage, count($sections)) ?> of <?= count($sections) ?> clubs.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include('frontend/partials/footer.inc.php') ?>
</body>

</html>