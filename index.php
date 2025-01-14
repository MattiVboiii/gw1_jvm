<?php
$url = $_GET['url'] ?? '';
$url_path = explode('?', $url);

function router(string $url, array $routes)
{
    foreach ($routes as $route => $callBack) {
        if (preg_match("/^$route$/i", $url, $params)) {
            $callBack($params);
            exit;
        }
    }
}

$routes = [
    '' => function () {
        include './frontend/index.php';
    },
    'club\/?(\d+)?' => function ($params) {
        $_GET['id'] = $params[1] ?? '';
        include './frontend/pages/detail.php';
    },
    'admin' => function () {
        include './backend/pages/home.php';
    },
    'admin\/login' => function () {
        include './backend/pages/login.php';
    },
    'admin\/clubs' => function () {
        include './backend/pages/clubs.php';
    },
    'admin\/clubs\/edit\/?(\d+)?' => function ($params) {
        $_GET['id'] = $params[1] ?? '';
        include './backend/pages/clubEdit.php';
    },
    'admin\/clubs\/create' => function ($params) {
        include './backend/pages/clubCreate.php';
    },
    '404' => function () {
        include './frontend/pages/404.php';
    },
    '.*' => function () {
        include './frontend/pages/404.php';
    }
];

router($url_path[0], $routes);
