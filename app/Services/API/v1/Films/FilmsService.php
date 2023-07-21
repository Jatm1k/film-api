<?php

namespace App\Services\API\v1\Films;

use App\Contracts\API\v1\Files\FilesHelper;
use App\Contracts\API\v1\Films\FilmsContract;
use App\Enums\API\v1\Directory;
use App\Models\API\v1\Film;
use Illuminate\Support\Facades\Storage;

class FilmsService implements FilmsContract
{
    private FilesHelper $helper;

    public function __construct(FilesHelper $helper)
    {
        $this->helper = $helper;
    }

    public function storeFilm(array $data): Film
    {
        $data['poster'] = $this->helper->uploadFile($data['poster'], Directory::FilmsPosters->value);
        $data['images'] = $this->helper->uploadFiles($data['images'], Directory::FilmsImages->value);
        return Film::query()->create($data);
    }

    public function updateFilm(Film $film, array $data): bool
    {
        $data['poster'] = $this->helper->uploadFile($data['poster'], Directory::FilmsPosters->value);
        $data['images'] = $this->helper->uploadFiles($data['images'], Directory::FilmsImages->value);
        $this->helper->deleteFiles(array_diff($film->images, $data['images']));
        return $film->update($data);
    }

    public function destroyFilm(Film $film): bool
    {
        $deleteFiles = $film->images;
        $deleteFiles[] = $film->poster;
        $this->helper->deleteFiles($deleteFiles);
        return $film->delete();
    }
}
