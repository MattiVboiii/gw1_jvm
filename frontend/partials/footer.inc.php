<?php

?>

<style>
    footer {
        background-color: var(--color-bg-footer);
        color: var(--color-text-footer);
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        position: relative;
        bottom: 0;
        width: 100%;

        ul {
            display: flex;
            list-style: none;
            align-items: center;
            padding: 0;
            margin: 0;
        }

        li {
            margin-left: 20px;
        }

        a {
            color: white;
            text-decoration: none;
        }
    }
</style>

<footer>
    <p>&copy; <?= date('Y') ?> - The Belgium Diamond</p>
    <ul>
        <li><a href="/frontend/index.php">Home</a></li>
        <li><a href="/admin/">Admin</a></li>
    </ul>
</footer>