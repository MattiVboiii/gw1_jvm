<?php
require_once 'system/db.inc.php';
include_once 'admin/php_includes/func.inc.php';

print '<pre>';
print_r(getClubs());
print '</pre>';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEBSITE HOMEPAGE</title>
    <link rel="stylesheet" href="/admin/css/style.css" />
    <script src="/admin/js/script.js" defer type="module"></script>
</head>

<body>
    <?php include('admin/partials/header.inc.php') ?>
    <?= "php works on backend website" ?>
    <p class="icon-pacman"></p>
    <img src="/admin/images/sample.jpg" alt="">
    <h2>php_includes work if 2 * 3 equals: <?= mul(2, 3) ?></h2>
</body>

</html>