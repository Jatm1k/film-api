<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\API\v1\Films\FilmsContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Film\StoreFilmRequest;
use App\Http\Requests\API\v1\Film\UpdateFilmRequest;
use App\Http\Resources\API\v1\Film\FilmMinifiedResource;
use App\Http\Resources\API\v1\Film\FilmResource;
use App\Http\Resources\API\v1\Review\ReviewResource;
use App\Models\API\v1\Film;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FilmController extends Controller
{
    private FilmsContract $service;

    public function __construct(FilmsContract $service)
    {
        $this->service = $service;

        $this->middleware('auth')->except('index', 'show', 'getReviews');
        $this->middleware('role:admin')->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $films = Film::query()->get();
        return response()->json(FilmMinifiedResource::collection($films));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFilmRequest $request)
    {
        return response()->json(
            new FilmResource(
                $this->service->storeFilm($request->validated())
            ),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        return response()->json(new FilmResource($film));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilmRequest $request, Film $film)
    {
        $this->service->updateFilm($film, $request->validated());
        return response()->json([
            'status' => __('response.status.success'),
            'message' => __('response.message.updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        $this->service->destroyFilm($film);

        return response()->json([
            'status' => __('response.status.success'),
            'message' => __('response.message.destroyed'),
        ]);
    }

    public function watch(Film $film)
    {
        $this->service->watch($film);
        return response()->json([
            'status' => __('response.status.success'),
            'message' => __('film.message.watch'),
        ]);
    }

    public function unwatch(Film $film)
    {
        $this->service->unwatch($film);
        return response()->json([
            'status' => __('response.status.success'),
            'message' => __('film.message.unwatch'),
        ]);
    }

    public function favorite(Film $film)
    {
        $this->service->favorite($film);
        return response()->json([
            'status' => __('response.status.success'),
            'message' => __('film.message.favorite'),
        ]);
    }

    public function unfavorite(Film $film)
    {
        $this->service->unfavorite($film);
        return response()->json([
            'status' => __('response.status.success'),
            'message' => __('film.message.unfavorite'),
        ]);
    }

    public function getReviews(Film $film)
    {
        return response()->json(
            ReviewResource::collection($film->reviews)
        );
    }
}
