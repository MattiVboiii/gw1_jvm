<?php
require_once 'system/Site/User.php';
include_once 'backend/php_includes/alerts.inc.php';

if (session_status() === PHP_SESSION_NONE) session_start();
global $user;
$user = Site\User::requireLogin('/admin/login');
enum NAV
{
    case HOME;
    case CLUBS;
    case TEAMS;

    public function ref(): string
    {
        return match ($this) {
            NAV::HOME => '/admin',
            NAV::CLUBS => '/admin/clubs',
            NAV::TEAMS => '/admin/teams',
            default => '#'
        };
    }
    public function icon()
    {
        return match ($this) {
            NAV::HOME => 'fa-solid fa-house',
            NAV::CLUBS => 'fa-solid fa-baseball',
            NAV::TEAMS => 'fa-solid fa-people-group',
            default => ''
        };
    }
}

function renderHeader(NAV $activePage)
{
?>
    <header class="sticky-top">
        <nav class="d-flex flex-column flex-shrink-0">
            <div class="nav-bg bg-gradient-primary"></div>
            <div class="nav-container">
                <div class="nav-header fs-4">
                    <?php renderNavUserMenu(direction: 'down', id: 'user-menu-mobile') ?>
                    <div class="align-items-center text-white pe-none">
                        <i class="fa-solid fa-baseball-bat-ball me-3 ms-2"></i>
                        <span>Admin</span>
                    </div>
                    <button class="navbar-toggler text-secondary px-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
                <hr class="mt-0 text-subtle-light">
            </div>
            <div class="nav-body d-flex flex-column h-100 ts-responsive">
                <?php renderNavBodyContents($activePage) ?>
            </div>
            <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasNavbar" aria-label="main navigation">
                <div class="offcanvas-body d-flex flex-column text-center">
                    <?php renderNavBodyContents($activePage) ?>
                </div>
            </div>
        </nav>
        <div class="container">
            <?php renderAlerts() ?>
        </div>
    </header>
<?php
}

function renderNavBodyContents(NAV $activePage)
{
?>
    <ul class="nav nav-pills nav-container flex-column mb-auto">
        <?php foreach (NAV::cases() as $navItem): ?>
            <li class="nav-item">
                <a href="<?= $navItem->ref() ?>" class="p-3 nav-link <?= $activePage === $navItem ? ' active' : '' ?>">
                    <i class="<?= $navItem->icon() ?> me-2"></i>
                    <span><?= ucwords(strtolower($navItem->name)) ?></span>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
    <?php renderNavUserMenu(id: 'user-menu-desktop') ?>
    <div class="d-flex justify-content-center mt-4 pb-3">
        <?php include 'backend/partials/theme-switcher.inc.php' ?>
    </div>
<?php
}

function renderNavUserMenu(string $direction = 'right', string $id = null)
{
    global $user;
    $directionClass = 'dropdown';
    if ($direction == 'right') {
        $directionClass = 'dropend';
    }
?>
    <div class="user-menu btn-group <?= $directionClass ?> px-lg-2" id="<?= $id ?>" role="group">
        <button type="button" class="btn dropdown-toggle mx-auto" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" data-bs-reference="parent" data-bs-offset="0,8">
            <div class="hstack gap-1">
                <div class="avatar-container">
                    <img src="/backend/images/default-avatar.png" alt="">
                </div>
                <div class="vstack">
                    <h4><?= mb_strimwidth($user->username, 0, 8, '…') ?></h4>
                    <p class="text-subtle-light"><?= mb_strimwidth($user->printPermRole(), 0, 11, '…') ?></p>
                </div>
            </div>
        </button>
        <div class="dropdown-menu p-0">
            <div class="card">
                <div class="card-header">
                    <div class="hstack gap-3">
                        <div class="avatar-container">
                            <img src="/backend/images/default-avatar.png" alt="">
                        </div>
                        <div>
                            <h4><?= $user->getFullName(); ?></h4>
                            <p class="text-subtle"><?= $user->email; ?></p>
                        </div>
                    </div>
                </div>
                <div class="card-body py-2 px-0">
                    <ul>
                        <li>
                            <form action="/admin/login" method="post">
                                <button type="submit" name="logoutSubmit" class="dropdown-item">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php
}
