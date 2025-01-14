<?php

namespace Site\Admin;

enum AlertType: string
{
    case SUCCESS = 'success';
    case WARNING = 'warning';
    case DANGER = 'danger';
    case INFO = 'info';

    function getIconClasses(): string
    {
        return match ($this) {
            AlertType::SUCCESS => 'fa-solid fa-circle-check',
            AlertType::WARNING => 'fa-solid fa-triangle-exclamation',
            AlertType::DANGER => 'fa-solid fa-circle-xmark',
            AlertType::INFO => 'fa-solid fa-circle-info'
        };
    }
}
