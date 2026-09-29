<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Place;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        
        // Category filtering & Search query handling
        $query = Place::with('category');

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $places = $query->get();

        return view('home', compact('places', 'categories'));
    }

    // Single Place Details View
    public function show($id)
    {
        // Place එක සහ ඊට අදාළ Category එක load කරගැනීම
        $place = Place::with('category')->findOrFail($id);

        // එම Category එකටම අයත් වෙනත් ස්ථාන (Related Places) 3ක් load කරගැනීම
        $relatedPlaces = Place::where('category_id', $place->category_id)
            ->where('id', '!=', $place->id)
            ->take(3)
            ->get();

        return view('places.show', compact('place', 'relatedPlaces'));
    }
}
