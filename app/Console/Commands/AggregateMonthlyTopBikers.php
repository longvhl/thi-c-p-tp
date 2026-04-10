<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rental;
use App\Models\MonthlyTopBiker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AggregateMonthlyTopBikers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:aggregate-monthly-bikers {month?} {year?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggregate top 10 bikers for a given month and year';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $targetMonth = $this->argument('month') ?? Carbon::now()->subMonth()->month;
        $targetYear = $this->argument('year') ?? Carbon::now()->subMonth()->year;

        $this->info("Aggregating for {$targetMonth}/{$targetYear}...");

        $topBikers = Rental::whereYear('start_time', $targetYear)
            ->whereMonth('start_time', $targetMonth)
            ->where('status', 'completed')
            ->select('user_id', DB::raw('count(*) as trips'))
            ->groupBy('user_id')
            ->orderByDesc('trips')
            ->take(10)
            ->with('user')
            ->get();

        MonthlyTopBiker::where('month', $targetMonth)
            ->where('year', $targetYear)
            ->delete();

        foreach ($topBikers as $tb) {
            $totalDuration = Rental::whereYear('start_time', $targetYear)
                ->whereMonth('start_time', $targetMonth)
                ->where('user_id', $tb->user_id)
                ->where('status', 'completed')
                ->get()
                ->sum(function ($r) {
                    return $r->start_time->diffInMinutes($r->end_time);
                });

            MonthlyTopBiker::create([
                'user_id' => $tb->user_id,
                'name' => $tb->user->name,
                'phone_last_3' => substr($tb->user->phone ?? '000', -3),
                'total_duration' => $totalDuration,
                'total_trips' => $tb->trips,
                'month' => $targetMonth,
                'year' => $targetYear
            ]);
        }

        $this->info("Done! Saved Top 10 bikers.");
    }
}
