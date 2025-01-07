<?php
enum ALERT_TYPE: string
{
    case SUCCESS = 'success';
    case WARNING = 'warning';
    case DANGER = 'danger';
    case INFO = 'info';

    function getIconClasses(): string
    {
        return match ($this) {
            ALERT_TYPE::SUCCESS => 'fa-solid fa-circle-check',
            ALERT_TYPE::WARNING => 'fa-solid fa-triangle-exclamation',
            ALERT_TYPE::DANGER => 'fa-solid fa-circle-xmark',
            ALERT_TYPE::INFO => 'fa-solid fa-circle-info'
        };
    }
}

class Alert
{
    public ALERT_TYPE $type;
    public string $msg;
    public bool $fleeting = true;
    public readonly string $id;

    function __construct(string $msg, ALERT_TYPE $type = ALERT_TYPE::INFO)
    {
        $this->id = uniqid();
        $this->type = $type;
        $this->msg = $msg;
    }

    function setType(ALERT_TYPE $type)
    {
        $this->type = $type;
        return $this;
    }

    function setMsg(string $msg)
    {
        $this->msg = $msg;
        return $this;
    }

    function setFleeting()
    {
        $this->fleeting = true;
        return $this;
    }

    function setPersistent()
    {
        throw new Exception('Not implemented');
        $this->fleeting = false;
        return $this;
    }

    public function add()
    {
        $_SESSION['alerts'][$this->id] = $this;
    }

    function remove()
    {
        unset($_SESSION['alerts'][$this->id]);
    }

    function render()
    {
?>
        <div class="alert alert-<?= $this->type->value ?> alert-dismissible d-flex align-items-center gap-3" role="alert">
            <i class="<?= $this->type->getIconClasses() ?> fs-4"></i>
            <div>
                <?= $this->msg ?>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    }
}

function addAlert(string $msg, ALERT_TYPE $type = ALERT_TYPE::INFO)
{
    (new Alert($msg, $type))->add();
}

function addSuccessAlert(string $msg)
{
    addAlert($msg, ALERT_TYPE::SUCCESS);
}

function addWarningAlert(string $msg)
{
    addAlert($msg, ALERT_TYPE::WARNING);
}

function addDangerAlert(string $msg)
{
    addAlert($msg, ALERT_TYPE::DANGER);
}

function addInfoAlert(string $msg)
{
    addAlert($msg, ALERT_TYPE::INFO);
}

function redirectWithAlert(string $url, string $msg, ALERT_TYPE $type = ALERT_TYPE::INFO)
{
    addAlert($msg, $type);
    header("Location: $url");
    exit;
}

function redirectWithSuccessAlert(string $url, string $msg)
{
    redirectWithAlert($url, $msg, ALERT_TYPE::SUCCESS);
}

function redirectWithWarningAlert(string $url, string $msg)
{
    redirectWithAlert($url, $msg, ALERT_TYPE::WARNING);
}

function redirectWithDangerAlert(string $url, string $msg)
{
    redirectWithAlert($url, $msg, ALERT_TYPE::DANGER);
}

function redirectWithInfoAlert(string $url, string $msg)
{
    redirectWithAlert($url, $msg, ALERT_TYPE::INFO);
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

if (session_status() === PHP_SESSION_NONE) session_start();
