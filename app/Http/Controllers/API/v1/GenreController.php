<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\API\v1\Genres\GenresContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Genre\StoreGenreRequest;
use App\Http\Requests\API\v1\Genre\UpdateGenreRequest;
use App\Http\Resources\API\v1\Genre\GenreMinifiedResource;
use App\Http\Resources\API\v1\Genre\GenreResource;
use App\Models\API\v1\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{

    private GenresContract $service;

    public function __construct(GenresContract $service)
    {
        $this->service = $service;

        $this->middleware(['auth', 'role:admin'])->only([
            'store',
            'update',
            'destroy',
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::query()->get();
        return response()->json(GenreMinifiedResource::collection($genres));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGenreRequest $request)
    {
        return response()->json(
            new GenreResource(
                $this->service->storeGenre($request->validated())
            ),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        return response()->json(new GenreResource($genre));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        $this->service->updateGenre($genre, $request->validated());
        return response()->json([
            'status' => __('response.status.success'),
            'message' => __('response.message.updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $this->service->destroyGenre($genre);
        return response()->json([
            'status' => __('response.status.success'),
            'message' => __('response.message.destroyed'),
        ]);
    }

}
