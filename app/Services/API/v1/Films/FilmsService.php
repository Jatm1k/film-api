<?php

namespace App\Services\API\v1\Films;

use App\Contracts\API\v1\Films\FilmsContract;
use App\Enums\API\v1\Directory;
use App\Facades\ExceptionHelper;
use App\Facades\FilesHelper;
use App\Models\API\v1\Film;
use App\Models\API\v1\Rating;
use App\Traits\API\v1\HasWatch;
use Illuminate\Database\Eloquent\Collection;

class FilmsService implements FilmsContract
{

    use HasWatch;

    public function storeFilm(array $data): Film
    {
        $data['poster'] = FilesHelper::uploadFile($data['poster'], Directory::FilmsPosters->value);
        $data['images'] = FilesHelper::uploadFiles($data['images'], Directory::FilmsImages->value);
        $film = Film::query()->create($data);
        $film->genres()->attach($data['genres']);
        return $film;
    }

    public function updateFilm(Film $film, array $data): void
    {
        $data['poster'] = FilesHelper::uploadFile($data['poster'], Directory::FilmsPosters->value);
        $data['images'] = FilesHelper::uploadFiles($data['images'], Directory::FilmsImages->value);
        FilesHelper::deleteFiles(array_diff($film->images, $data['images']));
        $film->update($data);
        $film->genres()->sync($data['genres']);
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

    public function favorite(Film $film): void
    {
        if ($this->isFavorite($film)) {
            ExceptionHelper::make(__('film.error.favorited'), 422);
        }
        $film->favouriteByUsers()->attach(auth()->id());
    }

    public function unfavorite(Film $film): void
    {
        if (!$this->isFavorite($film)) {
            ExceptionHelper::make(__('film.error.unfavorited'), 422);
        }
        $film->favouriteByUsers()->detach(auth()->id());
    }


    private function clearUserFilmInteraction(Film $film): void
    {
        $film->ratings->where('user_id', auth()->id())->first()?->delete();
        $film->reviews->where('user_id', auth()->id())->first()?->delete();
    }

    private function isFavorite(Film $film): bool
    {
        return $film->favouriteByUsers()->where('user_id', auth()->id())->exists();
    }


    public function recommendations(): Collection
    {
        $watchedFilms = auth()->user()->watchedFilms;

        if ($watchedFilms->count() > 0) {
            $genres = $watchedFilms
                ->flatMap(fn($film) => $film->genres)
                ->groupBy('id')
                ->sortByDesc(fn($group) => $group->count())->keys();

            $recommendations = Film::query()->whereHas(
                'genres',
                fn($query) => $query->whereIn('id', $genres->take(2))
            )
                ->whereDoesntHave('watchedByUsers', fn($query) => $query->where('id', auth()->id()))
                ->take(10)
                ->get();
        } else {
            $recommendations = Film::query()->inRandomOrder()
                ->whereDoesntHave('watchedByUsers', fn($query) => $query->where('id', auth()->id()))
                ->take(10)->get();
        }
        return $recommendations;
    }

    public function subscriptionsWatched(): Collection
    {
        $subscriptions = auth()->user()->subscriptions;
        
        if ($subscriptions->count() < 1) {
            ExceptionHelper::make(__('user.error.subscription_not_found'), 404);
        }

        return Film::query()
            ->whereHas('watchedByUsers', fn($query) => $query->whereIn('user_id', $subscriptions->pluck('id')))
            ->whereDoesntHave('watchedByUsers', fn($query) => $query->where('id', auth()->id()))
            ->get();
    }
}
