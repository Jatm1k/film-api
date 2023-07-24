<?php

namespace App\Services\API\v1\Files;

use App\Contracts\API\v1\Files\FilesHelper;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FilesService implements FilesHelper
{

    public function uploadFile(string|UploadedFile $file, string $dir): string
    {
        if (is_string($file)) {
            return $file;
        }

        $uploadedFile = Storage::put($dir, $file);
        return Storage::url($uploadedFile);
    }

    public function uploadFiles(?array $files, string $dir): array
    {
        return collect($files)->map(fn($file) => $this->uploadFile($file, $dir))->toArray();
    }

    public function deleteFile(string $file): void
    {
        $filePath = get_file_path($file);
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    }

    public function deleteFiles(array $files): void
    {
        collect($files)->each(fn($file) => $this->deleteFile($file));
    }
}
