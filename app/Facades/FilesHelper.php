<?php

namespace App\Facades;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string uploadFile(string|UploadedFile $file, string $dir)
 * @method static array uploadFiles(array|null $files, string $dir)
 * @method static void deleteFile(string $fileUrl)
 * @method static void deleteFiles(array $fileUrls)
 * */
class FilesHelper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'filesHelper';
    }
}
