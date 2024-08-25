<?php

namespace App\Http\Controllers;

use App\Http\Requests\RateRequest;
use App\Http\Requests\UpdateRateRequest;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start with a query on the Rating model
        $query = Rating::query();

        // Apply filters based on request parameters
        if ($request->has('movie_id')) {
            $query->where('movie_id', $request->movie_id);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('rating')) {
            $query->where('rating', $request->rating);
        }

        $perPage = $request->input('per_page', 10);

        $ratings = $query->paginate($perPage);

        return response()->json(['ratings' => $ratings] , 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RateRequest $request)
    {
        $validated = $request->validated();
        $rating = Rating::create($validated);
        return response()->json([
        'message' => 'Created Successfully',
        'rating' => $rating,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rating $rating)
    {
        $rating->get();
        return response()->json($rating , 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRateRequest $request, Rating $rating)
    {
        $validated = $request->validated();
        $rating->update($validated);
        return response()->json([
            'message' => 'Updated Successfully',
            'rating' => $rating,
        ] , 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return response()->json(NULL, 204);
    }
}
