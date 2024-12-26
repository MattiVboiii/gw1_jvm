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
                    <li><?= $club['name'] ?></li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <header>
            <p>BANNER - Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis harum quibusdam, accusantium magnam sapiente mollitia quae dicta, dolore consequuntur incidunt modi excepturi quod expedita saepe ipsa autem repellat suscipit nisi!</p>
        </header>
        <div class="club-container">
            <?php foreach (getClubs() as $club) : ?>
                <section style="background: url('<?= $club['logo_url'] ?>') no-repeat center/contain; height: 250px;">
                    <h2><?= $club['name'] ?></h2>
                </section>
            <?php endforeach; ?>
        </div>
        <footer>
            <p>FOOTER - Lorem ipsum dolor sit, amet consectetur adipisicing elit. Corrupti voluptate, nulla repellat cupiditate molestias voluptas tenetur, vitae minima maxime delectus dolore. Excepturi voluptas maxime quam nesciunt sequi, dolore illo. Quam!</p>
        </footer>
    </main>
</body>

</html>