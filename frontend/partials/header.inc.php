<?php
?>

<header>
    <div class="container">
        <nav>
            <div class="site-title">
                <div class="logo">
                    <img src="/frontend/images/logo_trimmed.png" alt="">
                </div>
                <h1>The Belgium Diamond</h1>
            </div>
            <ul>
                <li><a href="/frontend/index.php">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Clubs</a>
                    <ul class="dropdown-content">
                        <?php foreach (getClubs() as $club) : ?>
                            <li><a href="/frontend/pages/detail.php?id=<?= (int) $club['id'] ?>"><?= $club['name'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Provinces</a>
                    <ul class="dropdown-content">
                        <?php foreach (getProvinces() as $province) : ?>
                            <li><a href="/frontend/index.php?search=<?= $province['province'] ?>"><?= $province['province'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
            <div class="mobile-menu"> <i class="fa-solid fa-bars"></i></div>
        </nav>
    </div>
</header>