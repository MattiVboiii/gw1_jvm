<?php
require_once 'system/db.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="/frontend/css/header.css"> -->
    <link rel="stylesheet" href="/frontend/css/404.css">
    <link rel="stylesheet" href="/frontend/css/footer.css">
</head>

<body>
    <?php include('frontend/partials/header.inc.php') ?>
    <main>
        <div class="error404">
            <img src="/frontend/images/404.jpg" alt="404 page you're out! click home to return back to our webpage.">
        </div>
    </main>
    <?php include('frontend/partials/footer.inc.php') ?>
</body>

</html>