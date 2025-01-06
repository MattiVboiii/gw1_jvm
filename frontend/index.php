<?php
require_once 'system/db.inc.php';
include_once 'frontend/php_includes/func.inc.php';
// print '<pre>';
// print_r(getClubs());
// print '</pre>';
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
        <?php
        $sectionPerPage = 4;
        $page = (int) ($_GET['page'] ?? 1);
        $sections = getClubs();
        $totalSections = count($sections);
        $sectionsToShow = array_slice($sections, ($page - 1) * $sectionPerPage, $sectionPerPage);
        $totalPages = ceil($totalSections / $sectionPerPage);
        ?>
        <div class="club-container">
            <?php foreach ($sectionsToShow as $club) : ?>
                <a href="/frontend/pages/detail.php?id=<?= (int) $club['id'] ?>">
                    <section style="background-image: url('<?= htmlspecialchars($club['logo_url']) ?>');">
                        <h2><?= htmlspecialchars($club['name']) ?></h2>
                    </section>
                </a>
            <?php endforeach; ?>
            <div class="pagination">
                <a href="?page=<?= max(1, $page - 1) ?>" class="prev<?= $page <= 1 ? ' disabled' : '' ?>">&lt;</a>
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <a href="?page=<?= $i ?>" class="page-<?= $i ?><?= $i == $page ? ' active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
                <a href="?page=<?= min($totalPages, $page + 1) ?>" class="next<?= $page >= $totalPages ? ' disabled' : '' ?>">&gt;</a>
                <?php if ($totalSections > $sectionPerPage) : ?>
                    <p>Showing <?= ($page - 1) * $sectionPerPage + 1 ?> to <?= min($page * $sectionPerPage, $totalSections) ?> of <?= $totalSections ?> clubs.</p>
                <?php endif; ?>
            </div>
        </div>
        <footer>
            <p>FOOTER - Lorem ipsum dolor sit, amet consectetur adipisicing elit. Corrupti voluptate, nulla repellat cupiditate molestias voluptas tenetur, vitae minima maxime delectus dolore. Excepturi voluptas maxime quam nesciunt sequi, dolore illo. Quam!</p>
        </footer>
    </main>
</body>

</html>