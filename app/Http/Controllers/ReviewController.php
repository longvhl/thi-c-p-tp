<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'station_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $review = Review::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'station_id' => $request->station_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return response()->json([
            'success' => true,
            'review' => $review->load('user')
        ]);
    }

    /**
     * Fetch more reviews for a station.
     */
    public function getMore(Request $request)
    {
        $offset = $request->offset ?? 0;
        $stationId = $request->station_id;

        $reviews = Review::where('station_id', $stationId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit(5)
            ->get();

        $stats = Review::where('station_id', $stationId)
            ->select(DB::raw('AVG(rating) as avg, COUNT(*) as count'))
            ->first();

        $avg = round($stats->avg ?? 0, 1);
        $percent = round(($avg / 5) * 100);

        return response()->json([
            'reviews' => $reviews,
            'hasMore' => Review::where('station_id', $stationId)->count() > ($offset + 5),
            'stats' => [
                'avg' => $avg,
                'percent' => $percent,
                'count' => $stats->count
            ]
        ]);
    }
}
