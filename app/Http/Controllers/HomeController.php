<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Place;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Show the home page
    public function index(Request $request)
    {
        // Get all categories
        $categories = Category::all();

        // Get places with their categories
        $query = Place::with('category');

        // Filter places by category
        $category = $request->input('category');

        if ($category != '') {
            $query->where('category_id', $category);
        }

        // Search places by name
        $search = $request->input('search');

        if ($search != '') {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Get the final list of places
        $places = $query->get();

        // Send data to the home page
        return view('home', compact('places', 'categories'));
    }

    // Show details of one place
    public function show($id)
    {
        // Make sure the gallery table is ready
        \App\Support\GalleryTable::ensure();

        // Find the selected place with its category and images
        $place = Place::with(['category', 'images'])->findOrFail($id);

        // Find up to 3 other places in the same category
        $relatedPlaces = Place::where('category_id', $place->category_id)
            ->where('id', '!=', $place->id)
            ->take(3)
            ->get();

        // Send data to the place details page
        return view('places.show', compact('place', 'relatedPlaces'));
    }
}
