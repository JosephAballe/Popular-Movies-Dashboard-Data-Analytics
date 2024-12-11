<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function welcome(Request $request)
    {
        // Fetch distinct genres as a pipe-separated string
        $allGenres = DB::table('genre')
            ->select(DB::raw("GROUP_CONCAT(genres SEPARATOR '|') as all_genres"))
            ->first();

        $genres = collect(explode('|', $allGenres->all_genres))
            ->map(fn($genre) => trim($genre)) // Trim spaces around genres
            ->filter(fn($genre) => !empty($genre)) // Remove empty genres
            ->unique() // Remove duplicates
            ->sort() // Sort alphabetically
            ->values(); // Re-index the collection

        // Fetch distinct years from the 'movies' table
        $years = DB::table('movies')
            ->select(DB::raw('YEAR(Release_Date) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Fetch distinct countries (considering | separator and removing duplicates)
        $allCountries = DB::table('country')
            ->select(DB::raw("GROUP_CONCAT(countries SEPARATOR '|') as all_countries"))
            ->first();
        $countries = collect(explode('|', $allCountries->all_countries))
            ->map(fn($country) => trim($country)) // Trim spaces around countries
            ->unique() // Remove duplicates
            ->values(); // Re-index the collection

        // Start building the query to fetch movies
        $query = DB::table('movies');

        // Apply filters if any
        if ($request->filled('genre')) {
            $query->join('genre', 'movies.movie_id', '=', 'genre.movie_id')
                ->where('genre.genres', $request->genre);
        }
        if ($request->filled('year')) {
            $query->whereYear('Release_Date', $request->year);
        }

        // Apply country filter with LEFT JOIN (to allow movies without countries)
        if ($request->filled('country')) {
            $query->leftJoin('country', 'movies.movie_id', '=', 'country.movie_id')
                ->where('country.countries', $request->country);
        }

        // Fetch filtered movies (or all movies if no filters are applied)
        $filteredMovies = $query->get();

        // Calculate KPI data based on the filtered dataset
        $totalMovies = $filteredMovies->count(); // Total number of movies
        $totalRevenue = $filteredMovies->sum('Revenue');
        $totalBudget = $filteredMovies->sum('Budget');
        $averageRevenue = $totalMovies ? (float)$totalRevenue / $totalMovies : 0;
        $averageBudget = $totalMovies ? (float)$totalBudget / $totalMovies : 0;

        // Format the KPI data for display
        $totalMoviesFormatted = number_format($totalMovies);
        $averageRevenueFormatted = number_format((float)$averageRevenue / 1000000, 1); // Convert to millions and format
        $averageBudgetFormatted = number_format((float)$averageBudget / 1000000, 1); // Convert to millions and format

        // Fetch top 5 genres by revenue for the pie chart
        $topGenresByRevenue = DB::table('movies')
            ->join('genre', 'movies.movie_id', '=', 'genre.movie_id')
            ->select('genre.genres as genre', DB::raw('SUM(movies.Revenue) as total_revenue'))
            ->groupBy('genre.genres')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        // Prepare the pie chart data
        $pieChartData = $topGenresByRevenue->map(function ($item) {
            return [
                'genre' => $item->genre,
                'revenue' => (float)$item->total_revenue,
            ];
        })->toArray();

        // Calculate average revenue per genre for the last 10 years
        $yearsRange = 10;
        $currentYear = 2021;

        // Fetch average revenue per genre for the last 10 years
        $averageRevenueData = DB::table('movies')
            ->join('genre', 'movies.movie_id', '=', 'genre.movie_id')
            ->select('genre.genres as genre', DB::raw('YEAR(movies.Release_Date) as year'), DB::raw('AVG(movies.Revenue) as avg_revenue'))
            ->whereBetween(DB::raw('YEAR(movies.Release_Date)'), [$currentYear - $yearsRange, $currentYear])
            ->groupBy('genre.genres', 'year')
            ->orderBy('year', 'desc')
            ->get();

        // Organize the data for the chart
        $averageRevenueChartData = [];
        foreach ($averageRevenueData as $data) {
            $averageRevenueChartData[$data->year][] = [
                'genre' => $data->genre,
                'average_revenue' => $data->avg_revenue
            ];
        }

        // Calculate average budget per genre for the last 10 years (NEW)
        $averageBudgetData = DB::table('movies')
            ->join('genre', 'movies.movie_id', '=', 'genre.movie_id')
            ->select('genre.genres as genre', DB::raw('YEAR(movies.Release_Date) as year'), DB::raw('AVG(movies.Budget) as avg_budget'))
            ->whereBetween(DB::raw('YEAR(movies.Release_Date)'), [$currentYear - $yearsRange, $currentYear])
            ->groupBy('genre.genres', 'year')
            ->orderBy('year', 'desc')
            ->get();

        // Organize the average budget data for the chart
        $averageBudgetChartData = [];
        foreach ($averageBudgetData as $data) {
            $averageBudgetChartData[$data->year][] = [
                'genre' => $data->genre,
                'average_budget' => $data->avg_budget
            ];
        }

        // Fetch top 20 highest revenue movies with pagination (limit 6 per page)
        $topMovies = DB::table('movies')
            ->select('Original_Title', 'Release_Date', 'Popularity', 'Rating_average', 'Budget', 'Revenue')
            ->orderByDesc('Revenue')  // Order by highest revenue
            ->paginate(10);  // Paginate with 6 movies per page

        // Set default filter values if none are selected
        $defaultGenre = $request->filled('genre') ? $request->genre : '';
        $defaultYear = $request->filled('year') ? $request->year : '';
        $defaultCountry = $request->filled('country') ? $request->country : '';

        // Pass all the data to the view
        return view('welcome', [
            'genres' => $genres,
            'years' => $years,
            'countries' => $countries,
            'totalMovies' => $totalMoviesFormatted,
            'averageRevenue' => $averageRevenueFormatted,
            'averageBudget' => $averageBudgetFormatted,
            'defaultGenre' => $defaultGenre,
            'defaultYear' => $defaultYear,
            'defaultCountry' => $defaultCountry,
            'pieChartData' => $pieChartData, // Pie chart data
            'averageRevenueChartData' => $averageRevenueChartData, // Average revenue chart data
            'averageBudgetChartData' => $averageBudgetChartData, // Average budget chart data (NEW)
            'averageRevenueYears' => range($currentYear - $yearsRange, $currentYear), // Years for average revenue chart
            'topMovies' => $topMovies  // Top 20 movies with pagination

            
        ]);
    }
}
