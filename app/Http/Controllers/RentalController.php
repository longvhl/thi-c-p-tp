<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    // Render Rental Form
    public function create()
    {
        $wards = \App\Models\Ward::withCount('stations')
            ->orderByRaw('stations_count DESC, name ASC')
            ->get();
        $stations = \App\Models\Station::with('ward')->get();
        return view('frontend.rental', compact('wards', 'stations'));
    }

    public function getAvailableBikes($id)
    {
        $bikes = \App\Models\Bike::where('current_station', $id)
            ->where('status', 'available')
            ->get(['bike_number', 'type', 'unit_price']);
        return response()->json($bikes);
    }

    // Process Rent action
    public function store(Request $request)
    {
        $request->validate([
            'bike_number' => 'required|exists:bikes,bike_number',
            'station_slc' => 'required|not_in:--- Chọn Trạm Xe ---'
        ]);

        $activeRental = Rental::where('user_id', Auth::id())->where('status', 'active')->first();
        if ($activeRental) {
            return redirect('/active')->with('error', 'Bạn đang có một chuyến đi chưa kết thúc!');
        }

        $bike = \App\Models\Bike::where('bike_number', $request->bike_number)
            ->where('status', 'available')
            ->first();

        if (!$bike) {
            return redirect()->back()->with('error', 'Xe này hiện không sẵn sàng!');
        }

        $bikeMap = [
            'xe_thuong' => 'Xe đạp cơ',
            'xe_dien' => 'Xe đạp điện',
            'xe_troluc' => 'Xe trợ lực',
            'xe_thethao' => 'Xe thể thao'
        ];

        $station = \App\Models\Station::find($request->station_slc);
        $stationName = $station ? $station->name : $request->station_slc;

        Rental::create([
            'user_id' => Auth::id(),
            'bike_type' => $bike->type == 'xe_dien' ? 'Xe đạp điện' : ($bike->type == 'xe_thuong' ? 'Xe đạp cơ' : 'Xe trợ lực'),
            'station_start' => $stationName,
            'start_time' => Carbon::now(),
            'status' => 'active',
            'bike_number' => $bike->bike_number,
            'unit_price' => $bike->unit_price
        ]);

        $bike->update(['status' => 'rented']);

        return redirect('/active')->with('success', 'Thu thuê xe thành công!');
    }

    // Render Payment/Return Form
    public function paymentForm()
    {
        $activeRental = Rental::where('user_id', Auth::id())->where('status', 'active')->first();
        $wards = \App\Models\Ward::withCount('stations')
            ->orderByRaw('stations_count DESC, name ASC')
            ->get();
        return view('frontend.payment', compact('activeRental', 'wards'));
    }

    // Process Return Action
    public function returnBike(Request $request)
    {
        $rental = Rental::where('user_id', Auth::id())->where('status', 'active')->first();
        if (!$rental) {
            return redirect('/history')->with('error', 'Không có chuyến đi nào đang hoạt động!');
        }

        $request->validate([
            'return_station' => 'required|not_in:--- Chọn Trạm Xe ---'
        ]);

        $endTime = Carbon::now();
        $durationMinutes = ceil($rental->start_time->diffInSeconds($endTime) / 60);
        
        // Calculate cost: 5000 initial + (minutes * unitPrice)
        $totalCost = 5000 + ($durationMinutes * ($rental->unit_price ?? 200));

        $station = \App\Models\Station::find($request->return_station);
        $stationName = $station ? $station->name : $request->return_station;

        $rental->update([
            'station_end' => $stationName,
            'end_time' => $endTime,
            'total_cost' => $totalCost,
            'status' => 'completed'
        ]);

        $bike = \App\Models\Bike::where('bike_number', $rental->bike_number)->first();
        if ($bike) {
            $bike->update(['status' => 'available']);
        }

        if ($request->has('rating')) {
            \App\Models\Review::create([
                'user_id' => Auth::id(),
                'station_id' => $request->return_station,
                'bike_id' => $bike ? $bike->id : null,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
        }

        return redirect('/')->with('success', 'Đã trả xe thành công. Số tiền: ' . number_format($totalCost) . 'đ');
    }
}
