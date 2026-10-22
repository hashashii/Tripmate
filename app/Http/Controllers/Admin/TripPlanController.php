<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\TripPlan;

class TripPlanController extends Controller
{
    public function index()
    {
        $plans = TripPlan::latest()->paginate(15);

        return view('admin.trip-plans.index', compact('plans'));
    }

    public function show(TripPlan $tripPlan)
    {
        $ids = $tripPlan->selected_places ?? [];
        $byId = Place::whereIn('id', $ids)->get()->keyBy('id');

        $places = collect($ids)
            ->map(fn ($id) => $byId->get($id))
            ->filter()
            ->values();

        return view('admin.trip-plans.show', [
            'plan' => $tripPlan,
            'places' => $places,
        ]);
    }

    public function destroy(TripPlan $tripPlan)
    {
        $tripPlan->delete();

        return redirect()
            ->route('admin.trip-plans.index')
            ->with('success', 'Trip plan deleted.');
    }
}
