<?php

namespace Site\Admin;

enum UploadError: int
{
    case OK = UPLOAD_ERR_OK; //'File uploaded successfully',
    case INI_SIZE = UPLOAD_ERR_INI_SIZE; //'File is too big to upload',
    case FORM_SIZE = UPLOAD_ERR_FORM_SIZE; //'File is too big to upload',
    case PARTIAL = UPLOAD_ERR_PARTIAL; //'File was only partially uploaded',
    case NO_FILE = UPLOAD_ERR_NO_FILE; //'No file was uploaded',
    case NO_TMP_DIR = UPLOAD_ERR_NO_TMP_DIR; //'Missing a temporary folder on the server',
    case CANT_WRITE = UPLOAD_ERR_CANT_WRITE; //'File has failed to save to disk.',
    case EXTENSION = UPLOAD_ERR_EXTENSION; //'File is not allowed to upload to this server',

        // custom upload errors
    case EMPTY = 100;
    case TOO_LARGE = 101;
    case WRONG_TYPE = 102;


    public function message(): string
    {
        return match ($this) {
            self::OK => 'File uploaded successfully',
            self::INI_SIZE => 'File is too big to upload',
            self::FORM_SIZE => 'File is too big to upload',
            self::PARTIAL => 'File was only partially uploaded',
            self::NO_FILE => 'No file was uploaded',
            self::NO_TMP_DIR => 'Missing a temporary folder on the server',
            self::CANT_WRITE => 'File has failed to save to disk.',
            self::EXTENSION => 'File is not allowed to upload to this server',
            self::EMPTY => 'File is not allowed to be empty',
            self::TOO_LARGE => 'File exceeds the maximum size',
            self::WRONG_TYPE => 'File is of the wrong type',
            default => 'Unknown error occurred during file upload.'
        };
    }
}
