<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Place;
use App\Models\TripPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLogin()
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            if (auth()->user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return back()
            ->withErrors([
                'email' => 'Invalid login details or admin access denied.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'You have been signed out.');
    }

    public function dashboard()
    {
        return view('admin.dashboard', [
            'placesCount' => Place::count(),
            'categoriesCount' => Category::count(),
            'usersCount' => User::count(),
            'tripPlansCount' => TripPlan::count(),
            'recentPlaces' => Place::with('category')->latest()->take(5)->get(),
        ]);
    }

    public function placesIndex(Request $request)
    {
        $query = Place::with('category')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $places = $query->paginate(10)->withQueryString();

        return view('admin.places.index', compact('places'));
    }

    public function placesCreate()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.places.create', compact('categories'));
    }

    public function placesStore(Request $request)
    {
        $data = $this->validatePlace($request);

        Place::create($data);

        return redirect()->route('admin.places.index')
            ->with('success', 'Place added successfully.');
    }

    public function placesEdit(Place $place)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.places.edit', compact('place', 'categories'));
    }

    public function placesUpdate(Request $request, Place $place)
    {
        $place->update($this->validatePlace($request));

        return redirect()->route('admin.places.index')
            ->with('success', 'Place updated successfully.');
    }

    public function placesDestroy(Place $place)
    {
        $place->delete();

        return redirect()->route('admin.places.index')
            ->with('success', 'Place deleted successfully.');
    }

    private function validatePlace(Request $request)
    {
        return $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:10000',
            'distance_km' => 'required|numeric|min:0|max:999.99',
            'image' => 'nullable|url|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'facilities' => 'nullable|string|max:5000',
            'safety_info' => 'nullable|string|max:5000',
            'opening_hours' => 'nullable|string|max:255',
            'entrance_fee' => 'nullable|string|max:255',
            'accessibility' => 'nullable|string|max:5000',
            'travel_tips' => 'nullable|string|max:5000',
        ]);
    }
}
