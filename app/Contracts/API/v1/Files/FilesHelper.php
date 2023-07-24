<?php

namespace App\Contracts\API\v1\Files;

use Illuminate\Http\UploadedFile;

interface FilesHelper
{
    /**
     * @param UploadedFile|string $file
     * @param string $dir
     * @return string
     */
    public function uploadFile(UploadedFile|string $file, string $dir): string;

    /**
     * @param array|null $files
     * @param string $dir
     * @return array
     */
    public function uploadFiles(?array $files, string $dir): array;

    /**
     * @param string $file
     * @return void
     */
    public function deleteFile(string $file): void;

    /**
     * @param array $files
     * @return void
     */
    public function deleteFiles(array $files): void;
}
