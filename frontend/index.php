<?php

include 'system/db.inc.php';
include 'frontend/php_includes/func.inc.php';
print $test;
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
    <?= "php works on front website" ?>
    <p class="icon-pacman"></p>
    <img src="/frontend/images/sample.jpg" alt="">
    <h2>php_includes work if 2 + 2 equals: <?= sum(2, 2) ?></h2>
</body>

</html>