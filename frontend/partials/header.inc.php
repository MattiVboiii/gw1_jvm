<?php

?>

<style>
    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: "Inter", sans-serif;
        padding: 0 2vw;
        color: white;
        background-color: purple;

        img {
            width: 50px;
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
    <img src="/frontend/images/logo.png" alt="">
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