<?php
require_once 'system/db.inc.php';




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "admin/partials/head.inc.php" ?>
    <title>Admin - Login</title>
    <link rel="stylesheet" href="/admin/css/login.css">
    <script type="module" src="/admin/js/theme-switcher.js"></script>
</head>

<body class="bg-gradient-primary">
    <main class="container">
        <div class="card col-md-6 col-12 mx-auto text-center px-4">
            <div class="card-header p-4">
                <h1 class="fs-4">Sign in</h1>
            </div>
            <div class="card-body py-5 px-4">
                <form action="post">
                    <fieldset>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inputEmail" placeholder="Email...">
                            <label for="inputEmail">Email address</label>
                            <div class="invalid-feedback">
                                wrong!
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="inputPassword" placeholder="Password...">
                            <label for="inputPassword">Password</label>
                            <div class="invalid-feedback">
                                wrong!
                            </div>
                        </div>
                    </fieldset>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" name="submit" class="btn btn-primary ">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-footer p-4">
                <p class="text-secondary">Lost? <a href="/frontend/">Go back home.</a></p>
            </div>
        </div>
    </main>
</body>

</html>