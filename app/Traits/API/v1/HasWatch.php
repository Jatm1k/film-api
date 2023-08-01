<?php

namespace App\Traits\API\v1;

use App\Models\API\v1\Film;

trait HasWatch {

    private function isWatched(Film $film): bool {
        return $film->viewers()->where('user_id', auth()->id())->exists();
    }

    private function watching(Film $film): void {
        $film->viewers()->attach(['user_id' => auth()->id()]);
    }

    private function unwatching(Film $film): void {
        $film->viewers()->detach(['user_id' => auth()->id()]);
    }

}
