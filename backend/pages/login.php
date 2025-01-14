<?php
require_once 'system/Site/User.php';
require_once 'backend/php_includes/alerts.inc.php';

use Site\User;

if (session_status() === PHP_SESSION_NONE) session_start();

$email = $_POST['inputEmail'] ?? '';
$pass = $_POST['inputPassword'] ?? '';
$errors = [];

if (isset($_POST['submit'])) {
    $invalidPass = fn($input) => !preg_match('/^(?=.{8,}$)(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*]).*$/', $input);
    //                                          \__________/\_________/\_________/\_________/\______________/
    //                                             length      upper      lower      digit        symbol

    if (!$email) $errors['email'] = 'Email is required.';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Email is not valid.';

    if (!$pass) $errors['pass'] = 'Password is required.';
    elseif ($invalidPass($pass)) $errors['pass'] = 'Password must have at least:<ul><li>8 characters</li><li>1 capital letter</li><li>1 lowercase letter</li><li>1 digit</li><li>1 special character (!@#$%^&*)</li></ul>';

    if (!$errors) {
        $user = User::fetch($email);

        if (!$user?->verifyPass($pass)) {
            $errors['login'] = "Invalid login.";
        } elseif (!in_array($user->permissionRole, ['club admin', 'super admin'])) {
            $errors['perms'] = "You do not have admin permissions.";
        } else {
            $user->login();
            redirectWithSuccessAlert('/admin', "Welcome back $user->firstname.");
        }
    }
} elseif (isset($_POST['logoutSubmit'])) {
    User::getLoggedInUser()?->logout();
}

$makeGetValidationClass = function ($isSubmitted) use ($errors) {
    return function (string $errorKey) use ($errors, $isSubmitted) {
        if (!$isSubmitted) return;
        return isset($errors[$errorKey])
            ? 'is-invalid'
            : '';
    };
};
$getValidationClass = $makeGetValidationClass(isset($_POST['submit']))

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "backend/partials/head.inc.php" ?>
    <title>Admin - Login</title>
    <link rel="stylesheet" href="/backend/css/login.css">
    <script type="module" src="/backend/js/theme-switcher.js"></script>
</head>

<body class="bg-gradient-primary">
    <main class="container">
        <div class="card col-md-6 col-12 mx-auto text-center px-4">
            <div class="card-header p-4">
                <h1 class="fs-4">Sign in</h1>
            </div>
            <div class="card-body py-5 px-4">
                <form method="post" novalidate>
                    <fieldset>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control <?= $getValidationClass('email') ?> <?= $getValidationClass('login') ?>" name="inputEmail" id="inputEmail" placeholder="Email..." value="<?= $email ?>">
                            <label for="inputEmail">Email address</label>
                            <div class="invalid-feedback">
                                <?= $errors['email'] ?? '' ?>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control <?= $getValidationClass('pass') ?> <?= $getValidationClass('login') ?>" name="inputPassword" id="inputPassword" placeholder="Password...">
                            <label for="inputPassword">Password</label>
                            <div class="invalid-feedback">
                                <?= $errors['pass'] ?? '' ?>
                            </div>
                        </div>
                        <div>
                            <input type="hidden" class="<?= $getValidationClass('login') ?> <?= $getValidationClass('perms') ?>">
                            <div class="invalid-feedback">
                                <?= $errors['login'] ?? '' ?>
                                <?= $errors['perms'] ?? '' ?>
                            </div>
                        </div>
                    </fieldset>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" name="submit" class="btn btn-primary ">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-footer p-4">
                <p class="text-secondary">Lost? <a href="/">Go back home.</a></p>
            </div>
        </div>
    </main>
</body>

</html>