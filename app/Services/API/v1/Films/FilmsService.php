<?php

namespace App\Services\API\v1\Films;

use App\Contracts\API\v1\Files\FilesHelper;
use App\Contracts\API\v1\Films\FilmsContract;
use App\Enums\API\v1\Directory;
use App\Models\API\v1\Film;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

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

    public function updateFilm(Film $film, array $data): void
    {
        $data['poster'] = $this->helper->uploadFile($data['poster'], Directory::FilmsPosters->value);
        $data['images'] = $this->helper->uploadFiles($data['images'], Directory::FilmsImages->value);
        $this->helper->deleteFiles(array_diff($film->images, $data['images']));
        $film->update($data);
    }

    public function destroyFilm(Film $film): void
    {
        $deleteFiles = $film->images;
        $deleteFiles[] = $film->poster;
        $this->helper->deleteFiles($deleteFiles);
        $film->delete();
    }

    public function watch(Film $film): void
    {
        if ($film->viewers()->where('user_id', auth()->id())->exists()) {
            throw new HttpResponseException(
                response()->json([
                    'message' => __('film.error.watched')
                ], Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        $film->viewers()->attach(['user_id' => auth()->id()]);
    }
}
