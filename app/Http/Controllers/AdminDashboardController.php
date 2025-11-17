<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Lowongan;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalRoles = Role::count();
        $roleStats = Role::withCount('users')->get();
        $totalLowongan = Lowongan::count();
        $activeLowongan = Lowongan::where('status_aktif', true)->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRoles',
            'roleStats',
            'totalLowongan',
            'activeLowongan'
        ));
    }
}
