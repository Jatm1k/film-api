<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

if (!function_exists('upload_file')) {
    /**
     * @param  UploadedFile  $file
     * @param  string  $dir
     * @return string
     */
    function upload_file(UploadedFile $file, string $dir): string
    {
        $uploadedFile = Storage::put($dir, $file);
        return Storage::url($uploadedFile);
    }
}

if (!function_exists('upload_files')) {
    /**
     * @param  array|null  $files
     * @param  string  $dir
     * @return Collection
     */
    function upload_files(array|null $files, string $dir): Collection
    {
        return collect($files)->map(fn(UploadedFile $file) => upload_file($file, $dir));
    }
}