<?php

namespace App\Services\API\v1\Films;

use App\Contracts\API\v1\Films\FilmsContract;
use App\Enums\API\v1\Directory;
use App\Facades\ExceptionHelper;
use App\Facades\FilesHelper;
use App\Models\API\v1\Film;
use App\Models\API\v1\Rating;
use App\Traits\API\v1\HasWatch;

class FilmsService implements FilmsContract
{

    use HasWatch;

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
        $this->watching($film);
    }

    public function unwatch(Film $film): void
    {
        if (!$this->isWatched($film)) {
            ExceptionHelper::make(__('film.error.unwatched'), 422);
        }
        $this->clearUserFilmInteraction($film);
        $this->unwatching($film);
    }


    private function clearUserFilmInteraction(Film $film): void
    {
        $film->ratings->where('user_id', auth()->id())->first()?->delete();
        $film->reviews->where('user_id', auth()->id())->first()?->delete();
    }

}
