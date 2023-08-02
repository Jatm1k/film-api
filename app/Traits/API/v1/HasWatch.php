<?php

namespace App\Traits\API\v1;

use App\Models\API\v1\Film;

trait HasWatch
{

    private function isWatched(Film $film): bool
    {
        return $film->watchedByUsers()->where('user_id', auth()->id())->exists();
    }

    private function watching(Film $film): void
    {
        $film->watchedByUsers()->attach(auth()->id());
    }

    private function unwatching(Film $film): void
    {
        $film->watchedByUsers()->detach(auth()->id());
    }

}
