<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\API\v1\Films\FilmsContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Film\StoreFilmRequest;
use App\Http\Requests\API\v1\Film\UpdateFilmRequest;
use App\Http\Resources\API\v1\FilmResource;
use App\Models\API\v1\Film;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FilmController extends Controller
{
    private FilmsContract $service;

    public function __construct(FilmsContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $films = Film::query()->get();
        return response()->json(FilmResource::collection($films));
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
        return response()->json([
            'status' => $this->service->updateFilm($film, $request->validated())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        //
    }
}
