<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\API\v1\Reviews\ReviewsContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Review\StoreReviewRequest;
use App\Http\Requests\API\v1\Review\UpdateReviewRequest;
use App\Http\Resources\API\v1\Review\ReviewResource;
use App\Models\API\v1\Review;

class ReviewController extends Controller
{
    private ReviewsContract $service;

    public function __construct(ReviewsContract $service)
    {
        $this->service = $service;
        $this->middleware(['auth']);
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
    public function store(StoreReviewRequest $request)
    {
        return response()->json(
            new ReviewResource(
                $this->service->storeReview($request->validated())
            ),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $this->service->updateReview($review, $request->validated());
        return response()->json([
            'status' => __('response.status.success'),
            'message' => __('response.message.updated'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $this->service->destroyReview($review);
        return response()->json([
            'status' => __('response.status.success'),
            'message' => __('response.message.destroyed'),
        ]);
    }
}
