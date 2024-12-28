<?php

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
    <header>
        <nav class="d-flex flex-column flex-shrink-0 p-3 bg-body-secondary">
            <div class="align-items-center link-body-emphasis pe-none">
                <i class="fa-solid fa-baseball-bat-ball me-3 ms-2 fs-4"></i>
                <span class="fs-4">Admin</span>
            </div>
            <hr>
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
            <div class="d-flex justify-content-center ">
                <?php include 'admin/partials/theme-switcher.inc.php' ?>
            </div>
        </nav>
    </header>
<?php
}
