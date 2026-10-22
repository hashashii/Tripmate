<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Place;
use App\Models\TripPlan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'places' => Place::count(),
            'categories' => Category::count(),
            'plans' => TripPlan::count(),
            'users' => User::count(),
        ];

        $categories = Category::withCount('places')->orderBy('name')->get();
        $recentPlans = TripPlan::latest()->take(5)->get();
        $recentPlaces = Place::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats',
            'categories',
            'recentPlans',
            'recentPlaces'
        ));
    }
}
