<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\TripPlan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TripPlanController extends Controller
{
    public function index(Request $request)
    {
        $plans = TripPlan::whereIn(
            'id',
            $request->session()->get('trip_plan_ids', [])
        )
            ->latest()
            ->get();

        return view('planner.index', compact('plans'));
    }

    public function create(Request $request)
    {
        $places = Place::where('distance_km', '<=', 25)
            ->orderBy('name')
            ->get();

        $selectedPlace = $places->firstWhere(
            'id',
            (int) $request->query('place')
        );

        return view('planner.create', compact(
            'places',
            'selectedPlace'
        ));
    }

    public function store(Request $request)
    {
        // Remove empty stops while keeping the chosen order.
        $selectedPlaces = $request->input('selected_places', []);

        if (is_array($selectedPlaces)) {
            $request->merge([
                'selected_places' => array_values(
                    array_filter(
                        $selectedPlaces,
                        fn ($value) => $value !== null && $value !== ''
                    )
                ),
            ]);
        }

        $validated = $request->validate([
            'plan_name' => ['required', 'string', 'max:100'],
            'visit_date' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:today',
            ],
            'selected_places' => ['required', 'array', 'min:1'],
            'selected_places.*' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('places', 'id')->where(
                    fn ($query) => $query->where('distance_km', '<=', 25)
                ),
            ],
        ]);

        $validated['selected_places'] = array_map(
            'intval',
            $validated['selected_places']
        );

        $plan = TripPlan::create($validated);

        $planIds = $request->session()->get('trip_plan_ids', []);
        $planIds[] = $plan->id;

        $request->session()->put('trip_plan_ids', $planIds);

        return redirect()
            ->route('trip-plans.show', $plan)
            ->with('success', 'Your trip plan has been saved.');
    }

    public function show(Request $request, TripPlan $tripPlan)
    {
        $this->checkOwnership($request, $tripPlan);

        $placeIds = $tripPlan->selected_places ?? [];

        $placesById = Place::whereIn('id', $placeIds)
            ->get()
            ->keyBy('id');

        // Keep the same visit order saved by the visitor.
        $places = collect($placeIds)
            ->map(fn ($id) => $placesById->get($id))
            ->filter()
            ->values();

        return view('planner.show', [
            'plan' => $tripPlan,
            'places' => $places,
        ]);
    }

    public function destroy(Request $request, TripPlan $tripPlan)
    {
        $this->checkOwnership($request, $tripPlan);

        $planId = $tripPlan->id;

        $tripPlan->delete();

        $planIds = array_values(array_filter(
            $request->session()->get('trip_plan_ids', []),
            fn ($id) => (int) $id !== $planId
        ));

        $request->session()->put('trip_plan_ids', $planIds);

        return redirect()
            ->route('trip-plans.index')
            ->with('success', 'Trip plan deleted.');
    }

    private function checkOwnership(
        Request $request,
        TripPlan $tripPlan
    ): void {
        $planIds = array_map(
            'intval',
            $request->session()->get('trip_plan_ids', [])
        );

        abort_unless(in_array($tripPlan->id, $planIds, true), 404);
    }
}