<?php

namespace Site\Admin;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



enum MimeType: string
{
    case IMAGE_PNG = 'image/png';
    case IMAGE_JPEG = 'image/jpeg';
    case IMAGE_WEBP = 'image/webp';

    public static function fromFile(string $filePath): self|string
    {
        if (!$info = \finfo_open(FILEINFO_MIME_TYPE)) return null;
        $mimeType = \finfo_file($info, $filePath);
        \finfo_close($info);
        return self::tryFrom($mimeType) ?? $mimeType;
    }

    public function name()
    {
        return match ($this) {
            self::IMAGE_PNG => 'png',
            self::IMAGE_JPEG => 'jpeg',
            self::IMAGE_WEBP => 'webp',
            default => throw new \Exception('MimeType name not implemented')
        };
    }

    public function extension()
    {
        return '.' . $this->name();
    }

    static public function tryGetName(self|string $mimeType): string
    {
        return $mimeType?->name ?? explode('/', $mimeType)[1];
    }

    static public function tryGetExt(self|string $mimeType): string
    {
        return '.' . self::tryGetName($mimeType);
    }
}
