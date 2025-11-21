<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\Gallery;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'services' => Service::count(),
            'galleries' => Gallery::count(),
            'admins' => User::where('role', 'admin')->count(),
            'officers' => User::where('role', 'officer')->count(),
            'members' => User::where('role', 'member')->count(),
        ];

        $users = User::latest()->take(10)->get();
        $services = Service::latest()->take(10)->get();
        $galleries = Gallery::latest()->take(12)->get();
        
        // Get table counts
        $tables = [
            'users' => User::count(),
            'services' => Service::count(),
            'galleries' => Gallery::count(),
            'cache' => DB::table('cache')->count(),
            'cache_locks' => DB::table('cache_locks')->count(),
            'jobs' => DB::table('jobs')->count(),
            'job_batches' => DB::table('job_batches')->count(),
            'failed_jobs' => DB::table('failed_jobs')->count(),
            'password_reset_tokens' => DB::table('password_reset_tokens')->count(),
            'sessions' => DB::table('sessions')->count(),
        ];

        return view('admin.dashboard', compact('stats', 'users', 'services', 'galleries', 'tables'));
    }
}
