<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\TripPlan;
use Illuminate\Http\Request;

class TripPlanController extends Controller
{
    // Show saved trip plans
    public function index(Request $request)
    {
        $planIds = $request->session()->get('trip_plan_ids', []);

        $plans = TripPlan::whereIn('id', $planIds)
            ->latest()
            ->get();

        return view('planner.index', compact('plans'));
    }

    // Show the create trip plan form
    public function create(Request $request)
    {
        $places = Place::orderBy('name')->get();

        $selectedPlace = null;

        if ($request->has('place')) {
            $selectedPlace = $places->firstWhere(
                'id',
                (int) $request->query('place')
            );
        }

        return view('planner.create', compact(
            'places',
            'selectedPlace'
        ));
    }

    // Save a new trip plan
    public function store(Request $request)
    {
        // Get selected places from the form
        $selectedPlaces = $request->input('selected_places', []);

        // Remove empty selections
        $cleanPlaces = [];

        if (is_array($selectedPlaces)) {
            foreach ($selectedPlaces as $placeId) {
                if ($placeId !== null && $placeId !== '') {
                    $cleanPlaces[] = $placeId;
                }
            }
        }

        $request->merge([
            'selected_places' => $cleanPlaces
        ]);

        // Validate form data
        $validated = $request->validate([
            'plan_name' => 'required|string|max:100',
            'visit_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'selected_places' => 'required|array|min:1',
            'selected_places.*' => 'required|integer|distinct|exists:places,id',
        ]);

        // Convert place IDs to integers
        $placeIds = [];

        foreach ($validated['selected_places'] as $placeId) {
            $placeIds[] = (int) $placeId;
        }

        $validated['selected_places'] = $placeIds;

        // Save the trip plan
        $plan = TripPlan::create($validated);

        // Save the plan ID in the session
        $planIds = $request->session()->get('trip_plan_ids', []);
        $planIds[] = $plan->id;

        $request->session()->put('trip_plan_ids', $planIds);

        return redirect()
            ->route('trip-plans.show', $plan)
            ->with('success', 'Your trip plan has been saved.');
    }

    // Show one trip plan
    public function show(Request $request, TripPlan $tripPlan)
    {
        $this->checkOwnership($request, $tripPlan);

        $placeIds = $tripPlan->selected_places ?? [];

        $places = [];

        // Get places in the order selected by the user
        foreach ($placeIds as $placeId) {
            $place = Place::find($placeId);

            if ($place) {
                $places[] = $place;
            }
        }

        return view('planner.show', [
            'plan' => $tripPlan,
            'places' => collect($places),
        ]);
    }

    // Delete a trip plan
    public function destroy(Request $request, TripPlan $tripPlan)
    {
        $this->checkOwnership($request, $tripPlan);

        $planId = $tripPlan->id;

        // Delete the plan from the database
        $tripPlan->delete();

        // Remove the plan ID from the session
        $oldPlanIds = $request->session()->get('trip_plan_ids', []);
        $newPlanIds = [];

        foreach ($oldPlanIds as $id) {
            if ((int) $id !== (int) $planId) {
                $newPlanIds[] = $id;
            }
        }

        $request->session()->put('trip_plan_ids', $newPlanIds);

        return redirect()
            ->route('trip-plans.index')
            ->with('success', 'Trip plan deleted.');
    }

    // Check whether this session can access the plan
    private function checkOwnership(Request $request, TripPlan $tripPlan)
    {
        $planIds = $request->session()->get('trip_plan_ids', []);

        $hasAccess = false;

        foreach ($planIds as $id) {
            if ((int) $id === (int) $tripPlan->id) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            abort(404);
        }
    }
}
