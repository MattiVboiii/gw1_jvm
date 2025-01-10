<?php
?>

<style>
    nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-family: "Inter", sans-serif;
        padding: 0 2vw;
        color: white;
        background-color: #041e42;
        font-size: 1.2rem;

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        img {
            width: 50px;
        }

        h1 {
            font-weight: bold;
        }

        ul {
            display: flex;
            gap: 10px;

            a {
                color: white;
                text-decoration: none;
                padding: 10px;
            }
        }
    }

    .dropdown {
        position: relative;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        top: 20px;
        right: 0;
        background-color: lightgrey;
        min-width: 160px;
        z-index: 5;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover,
    .dropdown:hover .dropbtn {
        background-color: grey;
        color: white;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>

<nav>
    <div class="logo">
        <img src="/frontend/images/logo.png" alt="">
        <h1>The Belgium Diamond</h1>
    </div>
    <ul>
        <li class="dropdown">
            <a href="#" class="dropbtn">Clubs</a>
            <ul class="dropdown-content">
                <?php foreach (getClubs() as $club) : ?>
                    <li><a href="#"><?= $club['name'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropbtn">Teams</a>
            <ul class="dropdown-content">
                <?php foreach (getTeams() as $team) : ?>
                    <li><a href="#"><?= $team['name'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </li>
    </ul>
</nav>