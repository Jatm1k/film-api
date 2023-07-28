<?php

namespace App\Services\API\v1\Films;

use App\Contracts\API\v1\Films\FilmsContract;
use App\Enums\API\v1\Directory;
use App\Facades\ExceptionHelper;
use App\Facades\FilesHelper;
use App\Models\API\v1\Film;

class FilmsService implements FilmsContract
{
    public function storeFilm(array $data): Film
    {
        $data['poster'] = FilesHelper::uploadFile($data['poster'], Directory::FilmsPosters->value);
        $data['images'] = FilesHelper::uploadFiles($data['images'], Directory::FilmsImages->value);
        return Film::query()->create($data);
    }

    public function updateFilm(Film $film, array $data): void
    {
        $data['poster'] = FilesHelper::uploadFile($data['poster'], Directory::FilmsPosters->value);
        $data['images'] = FilesHelper::uploadFiles($data['images'], Directory::FilmsImages->value);
        FilesHelper::deleteFiles(array_diff($film->images, $data['images']));
        $film->update($data);
    }

    public function destroyFilm(Film $film): void
    {
        $deleteFiles = $film->images;
        $deleteFiles[] = $film->poster;
        FilesHelper::deleteFiles($deleteFiles);
        $film->delete();
    }

    public function watch(Film $film): void
    {
        if ($this->isWatched($film)) {
            ExceptionHelper::make(__('film.error.watched'), 422);
        }

        $film->viewers()->attach(['user_id' => auth()->id()]);
    }

    public function unwatch(Film $film): void
    {
        if (!$this->isWatched($film)) {
            ExceptionHelper::make(__('film.error.unwatched'), 422);
        }

        $film->viewers()->detach(['user_id' => auth()->id()]);
    }

    private function isWatched(Film $film): bool
    {
        return $film->viewers()->where('user_id', auth()->id())->exists();
    }
}
