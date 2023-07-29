<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\API\v1\Ratings\RatingsContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Rating\StoreRatingRequest;
use App\Http\Requests\API\v1\Rating\UpdateRatingRequest;
use App\Http\Resources\API\v1\Rating\RatingResource;
use App\Models\API\v1\Rating;

class RatingController extends Controller
{
    private RatingsContract $service;

    public function __construct(RatingsContract $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRatingRequest $request)
    {
        return response()->json(
            new RatingResource(
                $this->service->storeRating($request->validated())
            ),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRatingRequest $request, Rating $rating)
    {
        $this->service->updateRating($rating, $request->validated());
        return response()->json([
            'status' => __('response.status.success'),
            'message' => __('response.message.updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        $this->service->destroyRating($rating);
        return response()->json([
            'status' => __('response.status.success'),
            'message' => __('response.message.destroyed'),
        ]);
    }
}
