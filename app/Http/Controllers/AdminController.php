<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bike;
use App\Models\Station;

class AdminController extends Controller
{
    public function loginForm()
    {
        if (session()->has('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if (\Illuminate\Support\Facades\Auth::attempt(['email' => $username, 'password' => $password, 'role' => 'admin'])) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['message' => 'Tên đăng nhập hoặc mật khẩu không đúng.']);
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $totalBikes = Bike::count();
        $totalStations = Station::count();
        return view('admin.dashboard', compact('totalBikes', 'totalStations'));
    }
}
