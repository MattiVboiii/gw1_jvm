<?php
include 'backend/php_includes/Site/Admin/Alert.php';
include 'backend/php_includes/Site/Admin/AlertType.php';

use Site\Admin\{Alert, AlertType};

function addAlert(string $msg, AlertType $type = AlertType::INFO)
{
    (new Alert($msg, $type))->add();
}

function addSuccessAlert(string $msg)
{
    addAlert($msg, AlertType::SUCCESS);
}

function addWarningAlert(string $msg)
{
    addAlert($msg, AlertType::WARNING);
}

function addDangerAlert(string $msg)
{
    addAlert($msg, AlertType::DANGER);
}

function addInfoAlert(string $msg)
{
    addAlert($msg, AlertType::INFO);
}

function redirectWithAlert(string $url, string $msg, AlertType $type = AlertType::INFO)
{
    addAlert($msg, $type);
    header("Location: $url");
    exit;
}

function redirectWithSuccessAlert(string $url, string $msg)
{
    redirectWithAlert($url, $msg, AlertType::SUCCESS);
}

function redirectWithWarningAlert(string $url, string $msg)
{
    redirectWithAlert($url, $msg, AlertType::WARNING);
}

function redirectWithDangerAlert(string $url, string $msg)
{
    redirectWithAlert($url, $msg, AlertType::DANGER);
}

function redirectWithInfoAlert(string $url, string $msg)
{
    redirectWithAlert($url, $msg, AlertType::INFO);
}

function renderAlerts()
{
    $alerts = $_SESSION['alerts'] ?? [];

?>
    <ul>
        <?php foreach ($alerts as $id => $alert): ?>
            <li>
                <?php
                $alert->remove();
                $alert->render();
                ?>
            </li>
        <?php endforeach ?>
    </ul>
<?php
}
