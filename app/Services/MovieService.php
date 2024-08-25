<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovieService
{

    /**
     * Get all movies with optional pagination, filtering, and sorting.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllMovies(Request $request){
        $query = Movie::with('ratings');

        if ($request->has('genre')) {
            $genre = $request->genre;
            $query->where('genre', 'LIKE', "%$genre%");
        }

        if ($request->has('director')) {
            $query->where('director', $request->director);
        }

        if ($request->has('release_year')) {
            $query->where('release_year' , $request->release_year);
        }

        if ($request->has('sortBy')) {
            $sortOrder = $request->input('sortBy', 'asc');
            $query->orderBy('release_year', $sortOrder);
        }

        // Pagination
        $perPage = $request->input('per_page', 10);
        return $query->paginate($perPage);
    }


    /**
     * Create a new movie.
     * @param Movie $movie
     * @param array $data
     * @return Movie
     */
    public function createMovie(array $data)
    {
        try {
            $data['genre'] = implode(', ', $data['genre']);

            return Movie::create($data);
        } catch (\Exception $e) {
            Log::error('Failed to create movie: ' . $e->getMessage());
            throw new \Exception('Unable to create movie');
        }
    }

    /**
     * Update an existing movie.
     *
     * @param Movie $movie
     * @param array $data
     * @return Movie
     */
    public function updateMovie(Movie $movie, array $data)
    {
        try {
            
            if (isset($data['genre'])) {
                $data['genre'] = implode(', ', $data['genre']);
            }

            $movie->update($data);
            return $movie;
        } catch (\Exception $e) {
            Log::error('Failed to update movie: ' . $e->getMessage());
            throw new \Exception('Unable to update movie');
        }
    }

    /**
     * Delete a movie.
     *
     * @param Movie $movie
     * @return bool|null
     */
    public function deleteMovie(Movie $movie)
    {
        try {
            return $movie->delete();
        } catch (\Exception $e) {
            Log::error('Failed to delete movie: ' . $e->getMessage());
            throw new \Exception('Unable to delete movie');
        }
    }
}
