<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\Ward;

class AdminStationController extends Controller
{
    public function index()
    {
        $stations = Station::with('ward')->get();
        return view('admin.stations.index', compact('stations'));
    }

    public function create()
    {
        $wards = Ward::orderBy('name')->get();
        return view('admin.stations.create', compact('wards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:stations,code',
            'ward_id' => 'required|exists:wards,id',
            'image_url' => 'nullable|url'
        ]);

        Station::create($request->all());

        return redirect()->route('admin.stations.index')->with('success', 'Thêm trạm thành công!');
    }

    public function edit($id)
    {
        $station = Station::findOrFail($id);
        $wards = Ward::orderBy('name')->get();
        return view('admin.stations.edit', compact('station', 'wards'));
    }

    public function update(Request $request, $id)
    {
        $station = Station::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:stations,code,' . $id,
            'ward_id' => 'required|exists:wards,id',
            'image_url' => 'nullable|url'
        ]);

        $station->update($request->all());

        return redirect()->route('admin.stations.index')->with('success', 'Cập nhật trạm thành công!');
    }

    public function destroy($id)
    {
        $station = Station::findOrFail($id);
        // Check if there are bikes at this station? 
        // For simplicity, just delete or set current_station to null for those bikes.
        \App\Models\Bike::where('current_station', $id)->update(['current_station' => null]);
        $station->delete();

        return redirect()->route('admin.stations.index')->with('success', 'Xóa trạm thành công!');
    }
}
