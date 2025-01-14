<?php

namespace Site\Admin;

enum FileSizeUnits: int
{
    case BYTE = 0;
    case KILO_BYTE = 1;
    case MEGA_BYTE = 2;
    case GIGA_BYTE = 3;
    case TERA_BYTE = 4;
    case PETA_BYTE = 5;


    public function name(): string
    {
        return match ($this) {
            self::BYTE => 'byte',
            self::KILO_BYTE => 'kB',
            self::MEGA_BYTE => 'MB',
            self::GIGA_BYTE => 'GB',
            self::TERA_BYTE => 'TB',
            self::PETA_BYTE => 'PB',
            default => throw new \Exception('Name requested of unsupported FileSizeUnit')
        };
    }

    static function format(int $bytes, int $decimals = 2): string
    {
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{%$decimals}f", $bytes / pow(1024, $factor)) . self::from((int)$factor)?->name();
    }

    public function toBytes(int $amount)
    {
        return $amount * pow(1024, $this->value);
    }
}
