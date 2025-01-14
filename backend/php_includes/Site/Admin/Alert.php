<?php

namespace Site\Admin;

class Alert
{
    public AlertType $type;
    public string $msg;
    public bool $fleeting = true;
    public readonly string $id;

    function __construct(string $msg, AlertType $type = AlertType::INFO)
    {
        $this->id = uniqid();
        $this->type = $type;
        $this->msg = $msg;
    }

    function setType(AlertType $type)
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
        throw new \Exception('Not implemented');
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
