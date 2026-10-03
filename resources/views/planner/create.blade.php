@extends('layouts.app')

@section('content')
    @php
        $stops = old(
            'selected_places',
            [$selectedPlace?->id ?? '']
        );

        if (!is_array($stops) || count($stops) === 0) {
            $stops = [''];
        }
    @endphp

    <div class="mx-auto max-w-3xl px-4 py-12">
        <a
            href="{{ route('trip-plans.index') }}"
            class="text-sm font-semibold text-emerald-700 hover:underline"
        >
            ← My Trip Plans
        </a>

        <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm md:p-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Plan Your Day Trip
            </h1>

            <p class="mt-3 text-gray-600">
                Choose places within 25 km of our home.
                Add stops in the order you want to visit.
            </p>

            @if ($errors->any())
                <div class="mt-6 rounded-xl bg-red-50 p-4 text-sm text-red-700">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('trip-plans.store') }}"
                method="POST"
                class="mt-8 space-y-6"
            >
                @csrf

                <div>
                    <label
                        for="plan_name"
                        class="mb-2 block font-semibold text-gray-800"
                    >
                        Trip Name
                    </label>

                    <input
                        id="plan_name"
                        name="plan_name"
                        type="text"
                        value="{{ old('plan_name') }}"
                        placeholder="My weekend trip"
                        maxlength="100"
                        required
                        class="w-full rounded-xl border border-gray-300 px-4 py-3"
                    >
                </div>

                <div>
                    <label
                        for="visit_date"
                        class="mb-2 block font-semibold text-gray-800"
                    >
                        Visit Date
                    </label>

                    <input
                        id="visit_date"
                        name="visit_date"
                        type="date"
                        value="{{ old('visit_date') }}"
                        min="{{ now()->toDateString() }}"
                        required
                        class="w-full rounded-xl border border-gray-300 px-4 py-3"
                    >
                </div>

                <div>
                    <h2 class="font-semibold text-gray-800">
                        Visit Order
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Add a stop for each place you want to visit.
                    </p>

                    <div id="stops-container" class="mt-4 space-y-4">
                        @foreach ($stops as $chosen)
                            <div class="stop-row rounded-xl border border-gray-200 p-4">
                                <div class="mb-3 flex items-center justify-between gap-3">
                                    <label class="stop-label font-medium text-gray-700">
                                        Stop {{ $loop->iteration }}
                                    </label>

                                    <button
                                        type="button"
                                        class="remove-stop text-sm font-semibold text-red-600 hover:underline"
                                    >
                                        Remove
                                    </button>
                                </div>

                                <select
                                    name="selected_places[]"
                                    required
                                    class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3"
                                >
                                    <option value="">Choose a place</option>

                                    @foreach ($places as $place)
                                        <option
                                            value="{{ $place->id }}"
                                            @selected((string) $chosen === (string) $place->id)
                                        >
                                            {{ $place->name }} — {{ $place->distance_km }} km from home
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if ($places->isEmpty())
                    <p class="rounded-xl bg-amber-50 p-4 text-sm text-amber-800">
                        No places within 25 km are available yet.
                    </p>
                @else
                    <button
                        id="add-stop"
                        type="button"
                        class="w-full rounded-xl border border-emerald-600 px-6 py-3 font-semibold text-emerald-700 hover:bg-emerald-50"
                    >
                        + Add Another Stop
                    </button>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-emerald-600 px-6 py-3 font-semibold text-white hover:bg-emerald-700"
                    >
                        Save Trip Plan
                    </button>
                @endif
            </form>
        </div>
    </div>

    <template id="stop-template">
        <div class="stop-row rounded-xl border border-gray-200 p-4">
            <div class="mb-3 flex items-center justify-between gap-3">
                <label class="stop-label font-medium text-gray-700">
                    Stop
                </label>

                <button
                    type="button"
                    class="remove-stop text-sm font-semibold text-red-600 hover:underline"
                >
                    Remove
                </button>
            </div>

            <select
                name="selected_places[]"
                required
                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3"
            >
                <option value="">Choose a place</option>

                @foreach ($places as $place)
                    <option value="{{ $place->id }}">
                        {{ $place->name }} — {{ $place->distance_km }} km from home
                    </option>
                @endforeach
            </select>
        </div>
    </template>
@endsection

@push('scripts')
    <script>
        (() => {
            const container = document.getElementById('stops-container');
            const template = document.getElementById('stop-template');
            const addButton = document.getElementById('add-stop');

            function updateStops() {
                const rows = container.querySelectorAll('.stop-row');

                rows.forEach((row, index) => {
                    const label = row.querySelector('.stop-label');
                    const select = row.querySelector('select');
                    const removeButton = row.querySelector('.remove-stop');

                    select.id = `stop-${index + 1}`;
                    label.htmlFor = select.id;
                    label.textContent = `Stop ${index + 1}`;

                    removeButton.hidden = rows.length === 1;
                });
            }

            addButton?.addEventListener('click', () => {
                const newStop = template.content.cloneNode(true);

                container.appendChild(newStop);
                updateStops();

                container.lastElementChild.querySelector('select').focus();
            });

            container.addEventListener('click', (event) => {
                const removeButton = event.target.closest('.remove-stop');

                if (!removeButton) {
                    return;
                }

                if (container.querySelectorAll('.stop-row').length > 1) {
                    removeButton.closest('.stop-row').remove();
                    updateStops();
                }
            });

            updateStops();
        })();
    </script>
@endpush