<?php
$url = $_GET['url'] ?? '';
$url_path = explode('?', $url);

switch ($url_path[0]) {
    case '':
        include './frontend/index.php';
        break;
    case 'detail':
        include './frontend/pages/detail.php';
        break;
    case 'admin':
        include './backend/pages/home.php';
        break;
    case 'admin/login':
        include './backend/pages/login.php';
        break;
    case 'admin/clubs':
        include './backend/pages/clubs.php';
        break;
    case 'admin/clubs/edit':
        include './backend/pages/clubEdit.php';
        break;
    case 'admin/clubs/create':
        include './backend/pages/clubCreate.php';
        break;
    case '404':
    default:
        include './frontend/pages/404.php';
        break;
}
