<?php
include 'admin/php_includes/alerts.inc.php';

enum NAV
{
    case HOME;
    case CLUBS;
    case TEAMS;

    public function ref(): string
    {
        return match ($this) {
            NAV::HOME => '/admin/',
            NAV::CLUBS => '/admin/pages/clubs.php',
            NAV::TEAMS => '/admin/pages/teams.php',
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
        <nav class="d-flex flex-column flex-shrink-0 px-lg-3 bg-body-secondary">
            <div class="nav-header fs-4">
                <div class="align-items-center link-body-emphasis pe-none">
                    <i class="fa-solid fa-baseball-bat-ball me-3 ms-2"></i>
                    <span>Admin</span>
                </div>
                <button class="navbar-toggler text-secondary px-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <hr class="mt-0">
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
    <ul class="nav nav-pills flex-column mb-auto">
        <?php foreach (NAV::cases() as $navItem): ?>
            <li class="nav-item">
                <a href="<?= $navItem->ref() ?>" class="p-3 nav-link <?= $activePage === $navItem ? 'active' : 'link-body-emphasis' ?>">
                    <i class="<?= $navItem->icon() ?> me-2"></i>
                    <span><?= ucwords(strtolower($navItem->name)) ?></span>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
    <div class="d-flex justify-content-center mt-4 mb-3">
        <?php include 'admin/partials/theme-switcher.inc.php' ?>
    </div>
<?php
}
