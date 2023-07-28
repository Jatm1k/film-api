<?php

namespace App\Services\API\v1\Files;

use App\Contracts\API\v1\Files\FilesHelper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FilesService
{

    /**
     * @param string|UploadedFile $file
     * @param string $dir
     * @return string
     */
    public function uploadFile(string|UploadedFile $file, string $dir): string
    {
        if (is_string($file)) {
            return $file;
        }

        $uploadedFile = Storage::put($dir, $file);
        return Storage::url($uploadedFile);
    }

    /**
     * @param array|null $files
     * @param string $dir
     * @return array
     */
    public function uploadFiles(?array $files, string $dir): array
    {
        return collect($files)->map(fn($file) => $this->uploadFile($file, $dir))->toArray();
    }

    /**
     * @param string $fileUrl
     * @return void
     */
    public function deleteFile(string $fileUrl): void
    {
        $filePath = get_file_path($fileUrl);
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    }

    /**
     * @param array $fileUrls
     * @return void
     */
    public function deleteFiles(array $fileUrls): void
    {
        collect($fileUrls)->each(fn($fileUrl) => $this->deleteFile($fileUrl));
    }
}
