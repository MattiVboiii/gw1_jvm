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
    <!-- <?= "php works on front website" ?>
    <p class="icon-pacman"></p>
    <img src="/frontend/images/sample.jpg" alt="">
    <h2>php_includes work if 2 + 2 equals: <?= sum(2, 2) ?></h2> -->
    <main>
        <nav>
            <img src="/frontend/images/sample.jpg" alt="">
            <ul>
                <?php foreach (getClubs() as $club) : ?>
                    <li><a href="#"><?= $club['name'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <header>
            <p>BANNER - Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis harum quibusdam, accusantium magnam sapiente mollitia quae dicta, dolore consequuntur incidunt modi excepturi quod expedita saepe ipsa autem repellat suscipit nisi!</p>
        </header>
        <?php
        $sectionPerPage = 4;
        $page = (int) ($_GET['page'] ?? 1);
        $sections = getClubs();
        $sectionsToShow = array_slice($sections, ($page - 1) * $sectionPerPage, $sectionPerPage);
        ?>
        <div class="club-container">
            <?php foreach ($sectionsToShow as $club) : ?>
                <section style="background-image: url('<?= $club['logo_url'] ?>');">
                    <h2><?= $club['name'] ?></h2>
                </section>
            <?php endforeach; ?>
        </div>
        <div class="pagination">
            <?php if ($page > 1) : ?>
                <a href="?page=<?= $page - 1 ?>" class="prev">&lt;</a>
            <?php else : ?>
                <a class="prev" href="#" aria-disabled="true">&lt;</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= ceil(count($sections) / $sectionPerPage); $i++) : ?>
                <a href="?page=<?= $i ?>" class="page-<?= $i ?> <?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
            <?php if ($page < ceil(count($sections) / $sectionPerPage)) : ?>
                <a href="?page=<?= $page + 1 ?>" class="next">&gt;</a>
            <?php else : ?>
                <a class="next" href="#" aria-disabled="true">&gt;</a>
            <?php endif; ?>
        </div>
        <footer>
            <p>FOOTER - Lorem ipsum dolor sit, amet consectetur adipisicing elit. Corrupti voluptate, nulla repellat cupiditate molestias voluptas tenetur, vitae minima maxime delectus dolore. Excepturi voluptas maxime quam nesciunt sequi, dolore illo. Quam!</p>
        </footer>
    </main>
</body>

</html>