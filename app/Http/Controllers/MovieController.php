<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService){
        $this->movieService = $movieService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        $movies = $this->movieService->getAllMovies($request);

        return response()->json($movies, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieRequest $request){
        
        $movie = $this->movieService->createMovie($request->validated());

        return response()->json(['message' => 'Movie Created Successfully',
        'movie'=> $movie
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie){
        $movie->load('ratings');
    
        return response()->json($movie, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie){
        $updatedMovie = $this->movieService->updateMovie($movie, $request->validated());

        return response()->json(['message' => 'Movie Updated Successfuly',
        'movie' => $updatedMovie
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie){
        $this->movieService->deleteMovie($movie);

        return response()->json(null, 204);
    }

}
