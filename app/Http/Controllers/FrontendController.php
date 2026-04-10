<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    public function index()
    {
        $topBikers = \App\Models\MonthlyTopBiker::orderByDesc('total_trips')
            ->take(10)
            ->get();
            
        // Fallback for demo if no aggregation has run yet
        if ($topBikers->isEmpty()) {
            $topBikers = Rental::select('user_id', DB::raw('count(*) as total_trips'))
                ->groupBy('user_id')
                ->orderByDesc('total_trips')
                ->take(10)
                ->with('user')
                ->get();
            
            // Add required attributes for the view
            foreach($topBikers as $tb) {
                $tb->name = $tb->user->name;
                $tb->phone_last_3 = substr($tb->user->phone ?? '000', -3);
                $tb->total_duration = Rental::where('user_id', $tb->user_id)->where('status', 'completed')->get()->sum(function($r) {
                    return $r->start_time->diffInMinutes($r->end_time);
                });
            }
        }

        $totalBikes = \App\Models\Bike::count();
        $totalStationsCount = \App\Models\Station::count();
        
        $topStations = \App\Models\Station::all()->map(function($station) {
            $station->avg_rating = \App\Models\Review::where('station_id', 's' . $station->id)
                ->orWhere('station_id', $station->code)
                ->avg('rating') ?: 0;
            
            $station->recent_comments = \App\Models\Review::where('station_id', 's' . $station->id)
                ->orWhere('station_id', $station->code)
                ->latest()
                ->take(3)
                ->with('user')
                ->get();
                
            return $station;
        })->sortByDesc('avg_rating')->values()->take(10);
            
        return view('frontend.index', compact('topBikers', 'totalBikes', 'totalStationsCount', 'topStations'));
    }

    public function dashboard()
    {
        $user = Auth::user();
        $rentals = Rental::where('user_id', $user->id)->get();
        $totalTrips = $rentals->count();
        
        $totalMinutes = 0;
        foreach ($rentals->where('status', 'completed') as $r) {
            $totalMinutes += $r->start_time->diffInMinutes($r->end_time);
        }
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        $timeString = "{$hours}H {$minutes}M";

        return view('frontend.dashboard', compact('user', 'totalTrips', 'timeString'));
    }

    public function active()
    {
        $rental = Rental::where('user_id', Auth::id())->where('status', 'active')->first();
        return view('frontend.active', compact('rental'));
    }

    public function history()
    {
        $rentals = Rental::where('user_id', Auth::id())->where('status', 'completed')->orderBy('end_time', 'desc')->get();
        return view('frontend.history', compact('rentals'));
    }
}
