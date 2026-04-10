<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bike;
use App\Models\Station;
use App\Models\Review;

class AdminBikeController extends Controller
{
    public function index()
    {
        $bikes = Bike::with('station')->paginate(10);
        return view('admin.bikes.index', compact('bikes'));
    }

    public function create()
    {
        $stations = Station::all();
        return view('admin.bikes.create', compact('stations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bike_number' => 'required|unique:bikes',
            'type' => 'required',
            'current_station' => 'required|exists:stations,id',
            'status' => 'required',
        ]);

        Bike::create($request->all());

        return redirect()->route('admin.bikes.index')->with('success', 'Thêm xe thành công.');
    }

    public function show($id)
    {
        $bike = Bike::with(['station', 'reviews.user'])->findOrFail($id);
        return view('admin.bikes.show', compact('bike'));
    }

    public function edit($id)
    {
        $bike = Bike::findOrFail($id);
        $stations = Station::all();
        return view('admin.bikes.edit', compact('bike', 'stations'));
    }

    public function update(Request $request, $id)
    {
        $bike = Bike::findOrFail($id);
        
        $request->validate([
            'bike_number' => 'required|unique:bikes,bike_number,' . $id,
            'type' => 'required',
            'current_station' => 'required|exists:stations,id',
            'status' => 'required',
        ]);

        $bike->update($request->all());

        return redirect()->route('admin.bikes.index')->with('success', 'Cập nhật xe thành công.');
    }

    public function destroy($id)
    {
        $bike = Bike::findOrFail($id);
        $bike->delete();

        return redirect()->route('admin.bikes.index')->with('success', 'Xóa mềm xe thành công.');
    }

    public function bin()
    {
        $bikes = Bike::onlyTrashed()->with('station')->paginate(10);
        return view('admin.bikes.bin', compact('bikes'));
    }

    public function restore($id)
    {
        $bike = Bike::onlyTrashed()->findOrFail($id);
        $bike->restore();

        return redirect()->route('admin.bikes.bin')->with('success', 'Khôi phục xe thành công.');
    }

    public function forceDelete($id)
    {
        $bike = Bike::onlyTrashed()->findOrFail($id);
        $bike->forceDelete();

        return redirect()->route('admin.bikes.bin')->with('success', 'Xóa vĩnh viễn xe thành công.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('bike_ids');
        if($ids && is_array($ids)) {
            Bike::whereIn('id', $ids)->delete();
            return back()->with('success', 'Đã xóa mềm các xe được chọn.');
        }
        return back()->with('error', 'Chưa chọn xe nào.');
    }

    public function bulkRestore(Request $request)
    {
        $ids = $request->input('bike_ids');
        if($ids && is_array($ids)) {
            Bike::onlyTrashed()->whereIn('id', $ids)->restore();
            return back()->with('success', 'Đã khôi phục các xe được chọn.');
        }
        return back()->with('error', 'Chưa chọn xe nào.');
    }
}
