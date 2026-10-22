@extends('admin.layout')
@section('title', 'Trip plans')
@section('heading', 'Trip plans')

@section('content')
<div class="overflow-x-auto rounded-xl bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="border-b bg-gray-50 text-xs uppercase text-gray-500">
            <tr>
                <th class="px-4 py-3">Plan</th>
                <th class="px-4 py-3">Visit date</th>
                <th class="px-4 py-3">Stops</th>
                <th class="px-4 py-3">Created</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($plans as $plan)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $plan->plan_name ?? 'Untitled' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ optional($plan->visit_date)->format('M j, Y') ?? '—' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ count($plan->selected_places ?? []) }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $plan->created_at?->diffForHumans() }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.trip-plans.show', $plan) }}" class="font-medium text-emerald-600 hover:underline">View</a>
                        <form method="POST" action="{{ route('admin.trip-plans.destroy', $plan) }}" class="ml-3 inline" onsubmit="return confirm('Delete this plan?')">
                            @csrf @method('DELETE')
                            <button class="font-medium text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No trip plans yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $plans->links() }}</div>
@endsection
