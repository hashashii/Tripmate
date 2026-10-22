
@php
    // Get the place when editing an existing record
    $p = $place ?? null;
@endphp

@csrf

{{-- Show validation errors --}}
@if ($errors->any())
    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">
        <p class="mb-1 font-semibold">Could not save. Please fix the following:</p>

        <ul class="list-disc space-y-0.5 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid gap-5 md:grid-cols-2">

    {{-- Place name --}}
    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-medium">Name</label>

        <input
            type="text"
            name="name"
            value="{{ old('name', $p->name ?? '') }}"
            required
            class="w-full rounded-lg border border-gray-300 px-3 py-2"
        >

        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Category --}}
    <div>
        <label class="mb-1 block text-sm font-medium">Category</label>

        <select
            name="category_id"
            required
            class="w-full rounded-lg border border-gray-300 px-3 py-2"
        >
            <option value="">Select...</option>

            @foreach ($categories as $c)
                <option
                    value="{{ $c->id }}"
                    @selected(old('category_id', $p->category_id ?? '') == $c->id)
                >
                    {{ $c->name }}
                </option>
            @endforeach
        </select>

        @error('category_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Distance from home --}}
    <div>
        <label class="mb-1 block text-sm font-medium">Distance from home (km)</label>

        <input
            type="number"
            step="0.01"
            min="0"
            name="distance_km"
            value="{{ old('distance_km', $p->distance_km ?? '') }}"
            required
            class="w-full rounded-lg border border-gray-300 px-3 py-2"
        >

        <p class="mt-1 text-xs text-gray-500">
            Places within 25 km can be added to trip plans.
        </p>

        @error('distance_km')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-medium">Description</label>

        <textarea
            name="description"
            rows="4"
            required
            class="w-full rounded-lg border border-gray-300 px-3 py-2"
        >{{ old('description', $p->description ?? '') }}</textarea>

        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Latitude --}}
    <div>
        <label class="mb-1 block text-sm font-medium">Latitude</label>

        <input
            type="text"
            name="latitude"
            value="{{ old('latitude', $p->latitude ?? '') }}"
            class="w-full rounded-lg border border-gray-300 px-3 py-2"
        >

        @error('latitude')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Longitude --}}
    <div>
        <label class="mb-1 block text-sm font-medium">Longitude</label>

        <input
            type="text"
            name="longitude"
            value="{{ old('longitude', $p->longitude ?? '') }}"
            class="w-full rounded-lg border border-gray-300 px-3 py-2"
        >

        @error('longitude')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Facilities --}}
    <div>
        <label class="mb-1 block text-sm font-medium">Facilities</label>

        <textarea
            name="facilities"
            rows="3"
            class="w-full rounded-lg border border-gray-300 px-3 py-2"
        >{{ old('facilities', $p->facilities ?? '') }}</textarea>

        @error('facilities')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Safety information --}}
    <div>
        <label class="mb-1 block text-sm font-medium">Safety Info</label>

        <textarea
            name="safety_info"
            rows="3"
            class="w-full rounded-lg border border-gray-300 px-3 py-2"
        >{{ old('safety_info', $p->safety_info ?? '') }}</textarea>

        @error('safety_info')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Opening hours --}}
    <div>
        <label class="mb-1 block text-sm font-medium">Opening Hours</label>

        <input
            type="text"
            name="opening_hours"
            value="{{ old('opening_hours', $p->opening_hours ?? '') }}"
            placeholder="e.g. 8.00 AM - 5.00 PM"
            class="w-full rounded-lg border border-gray-300 px-3 py-2"
        >

        @error('opening_hours')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Entrance fee --}}
    <div>
        <label class="mb-1 block text-sm font-medium">Entrance Fee</label>

        <input
            type="text"
            name="entrance_fee"
            value="{{ old('entrance_fee', $p->entrance_fee ?? '') }}"
            placeholder="e.g. Free / Rs. 500 per person"
            class="w-full rounded-lg border border-gray-300 px-3 py-2"
        >

        @error('entrance_fee')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Accessibility details --}}
    <div>
        <label class="mb-1 block text-sm font-medium">Accessibility</label>

        <textarea
            name="accessibility"
            rows="3"
            placeholder="Parking, road access, wheelchair access..."
            class="w-full rounded-lg border border-gray-300 px-3 py-2"
        >{{ old('accessibility', $p->accessibility ?? '') }}</textarea>

        @error('accessibility')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Travel tips --}}
    <div>
        <label class="mb-1 block text-sm font-medium">Travel Tips</label>

        <textarea
            name="travel_tips"
            rows="3"
            placeholder="Best time to visit, things to bring..."
            class="w-full rounded-lg border border-gray-300 px-3 py-2"
        >{{ old('travel_tips', $p->travel_tips ?? '') }}</textarea>

        @error('travel_tips')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Main image --}}
    <div class="md:col-span-2 rounded-lg border border-dashed border-gray-300 p-4">
        <label class="mb-2 block text-sm font-medium">
            Main image
            <span class="font-normal text-gray-500">(optional)</span>
        </label>

        {{-- Show current image when editing --}}
        @if (!empty($p?->image))
            @php
                $src = filter_var($p->image, FILTER_VALIDATE_URL)
                    ? $p->image
                    : asset(ltrim($p->image, '/'));
            @endphp

            <img
                src="{{ $src }}"
                alt=""
                class="mb-3 h-32 rounded-lg object-cover"
            >
        @endif

        <div class="grid gap-3 md:grid-cols-2">
            <div>
                <input
                    type="text"
                    name="image_path"
                    value="{{ old('image_path', $p->image ?? '') }}"
                    placeholder="images/places/place.png or https://..."
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"
                >

                <p class="mt-1 text-xs text-gray-500">
                    Enter an image path or URL, or keep the current image.
                </p>

                @error('image_path')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input
                    type="file"
                    name="image_file"
                    accept="image/*"
                    class="block w-full text-sm"
                >

                <p class="mt-1 text-xs text-gray-500">
                    Or upload a photo from your computer.
                </p>

                @error('image_file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- Photo gallery --}}
    <div class="md:col-span-2 rounded-lg border border-gray-200 bg-gray-50 p-4">

        <div class="mb-3 flex items-center justify-between">
            <label class="text-sm font-medium">Photo Gallery</label>

            <span class="text-xs text-gray-500">
                Shown on the place page
            </span>
        </div>

        {{-- Show existing gallery images --}}
        @if ($p && $p->images->count())
            <p class="mb-2 text-xs text-gray-500">
                Tick the photos you want to remove, then press Save.
            </p>

            <div class="mb-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ($p->images as $img)
                    <label class="group relative block cursor-pointer overflow-hidden rounded-lg border border-gray-200 bg-white">
                        <img
                            src="{{ $img->url }}"
                            alt=""
                            loading="lazy"
                            class="aspect-[4/3] w-full object-cover"
                        >

                        <span class="absolute left-2 top-2 flex items-center gap-1 rounded bg-white/90 px-2 py-1 text-xs font-medium text-red-600 shadow">
                            <input
                                type="checkbox"
                                name="remove_images[]"
                                value="{{ $img->id }}"
                                class="rounded"
                            >
                            Remove
                        </span>
                    </label>
                @endforeach
            </div>
        @endif

        {{-- Upload multiple gallery images --}}
        <input
            type="file"
            id="gallery-input"
            name="gallery[]"
            accept="image/*"
            multiple
            class="block w-full text-sm"
        >

        <p class="mt-1 text-xs text-gray-500">
            Select multiple photos at once (max 20 per save).
        </p>

        @error('gallery')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        @error('gallery.*')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        {{-- Preview selected gallery images --}}
        <div
            id="gallery-preview"
            class="mt-3 grid grid-cols-3 gap-2 sm:grid-cols-6"
        ></div>

        {{-- Add gallery images using paths or URLs --}}
        <div class="mt-4">
            <label class="mb-1 block text-xs font-medium text-gray-600">
                Or add by link / path (one per line, optional)
            </label>

            <textarea
                name="gallery_links"
                rows="3"
                placeholder="images/places/place.png&#10;https://example.com/photo.jpg"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"
            >{{ old('gallery_links') }}</textarea>

            @error('gallery_links')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

</div>

{{-- Image compression and gallery preview --}}
<script>
    (function () {
        var MAX_SIDE = 1920;
        var QUALITY = 0.85;
        var SKIP_BELOW = 1.2 * 1024 * 1024;

        // Reduce large images before uploading.
        function shrink(file) {
            return new Promise(function (resolve) {
                if (!/^image\/(jpeg|png|webp)$/.test(file.type)) {
                    return resolve(file);
                }

                var url = URL.createObjectURL(file);
                var img = new Image();

                img.onload = function () {
                    var scale = Math.min(
                        1,
                        MAX_SIDE / Math.max(img.width, img.height)
                    );

                    if (scale === 1 && file.size < SKIP_BELOW) {
                        URL.revokeObjectURL(url);
                        return resolve(file);
                    }

                    var canvas = document.createElement('canvas');

                    canvas.width = Math.round(img.width * scale);
                    canvas.height = Math.round(img.height * scale);

                    var context = canvas.getContext('2d');

                    context.fillStyle = '#fff';
                    context.fillRect(0, 0, canvas.width, canvas.height);

                    context.drawImage(
                        img,
                        0,
                        0,
                        canvas.width,
                        canvas.height
                    );

                    canvas.toBlob(function (blob) {
                        URL.revokeObjectURL(url);

                        if (!blob || blob.size >= file.size) {
                            return resolve(file);
                        }

                        var name = file.name.replace(/\.[^.]+$/, '');

                        resolve(new File(
                            [blob],
                            name + '.jpg',
                            { type: 'image/jpeg' }
                        ));
                    }, 'image/jpeg', QUALITY);
                };

                img.onerror = function () {
                    URL.revokeObjectURL(url);
                    resolve(file);
                };

                img.src = url;
            });
        }

        // Compress selected files and update the file input.
        function hook(input, onDone) {
            if (!input) return;

            input.addEventListener('change', function () {
                var files = Array.from(input.files);

                Promise.all(files.map(shrink)).then(function (output) {
                    try {
                        var data = new DataTransfer();

                        output.forEach(function (file) {
                            data.items.add(file);
                        });

                        input.files = data.files;
                    } catch (error) {
                        // Keep original files if compression cannot be applied.
                    }

                    if (onDone) {
                        onDone(Array.from(input.files));
                    }
                });
            });
        }

        // Preview selected gallery photos.
        var box = document.getElementById('gallery-preview');

        hook(document.getElementById('gallery-input'), function (files) {
            box.innerHTML = '';

            files.forEach(function (file) {
                var img = document.createElement('img');

                img.src = URL.createObjectURL(file);
                img.className = 'aspect-square w-full rounded-lg object-cover';

                box.appendChild(img);
            });
        });

        // Compress the main image too.
        hook(document.querySelector('input[name="image_file"]'));
    })();
</script>

{{-- Save and cancel buttons --}}
<div class="mt-6 flex gap-3">
    <button
        type="submit"
        class="rounded-lg bg-emerald-600 px-5 py-2.5 font-semibold text-white hover:bg-emerald-700"
    >
        Save
    </button>

    <a
        href="{{ route('admin.places.index') }}"
        class="rounded-lg border border-gray-300 px-5 py-2.5 font-medium text-gray-700 hover:bg-gray-50"
    >
        Cancel
    </a>
</div>
