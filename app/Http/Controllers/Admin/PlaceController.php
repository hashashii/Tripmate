<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Place;
use App\Models\PlaceImage;
use App\Support\GalleryTable;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

class PlaceController extends Controller
{
    private const IMAGE_DIR = 'images/places';
    private const PATH_REGEX = '#^(https?://\S+|images/places/[A-Za-z0-9._\-]+)$#i';
    private const EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'jfif'];

    
    private array $galleryLinks = [];

    public function __construct()
    {
        GalleryTable::ensure();
    }

    public function index(Request $request)
    {
        $query = Place::with('category')->withCount('images')->orderBy('name');

        if ($search = trim((string) $request->query('search'))) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($categoryId = $request->query('category')) {
            $query->where('category_id', $categoryId);
        }

        $places = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.places.index', compact('places', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.places.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['image'] = $this->resolveImage($request, null);

        $place = Place::create($data);
        $this->saveGallery($request, $place);

        return redirect()
            ->route('admin.places.edit', $place)
            ->with('success', 'Place created. You can add more gallery photos here.');
    }

    public function edit(Place $place)
    {
        $categories = Category::orderBy('name')->get();
        $place->load('images');

        return view('admin.places.edit', compact('place', 'categories'));
    }

    public function update(Request $request, Place $place)
    {
        $data = $this->validated($request);
        $oldImage = $place->image;
        $data['image'] = $this->resolveImage($request, $place);

        $place->update($data);

        if ($oldImage && $oldImage !== $place->image) {
            $this->deleteFileIfUnused($oldImage);
        }

        $this->removeGalleryImages($request, $place);
        $this->saveGallery($request, $place);

        return redirect()
            ->route('admin.places.edit', $place)
            ->with('success', 'Place updated.');
    }

    public function destroy(Place $place)
    {
        $paths = $place->images()->pluck('path')->all();
        if ($place->image) {
            $paths[] = $place->image;
        }

        $place->images()->delete();
        $place->delete();

        foreach ($paths as $path) {
            $this->deleteFileIfUnused($path);
        }

        return redirect()
            ->route('admin.places.index')
            ->with('success', 'Place deleted.');
    }

    private function validated(Request $request): array
    {
        // Normalise the main image path/URL typed by the admin.
        $request->merge(['image_path' => $this->normalisePath($request->input('image_path'))]);

        $imageRules = [
            'nullable', 'file', 'max:10240',
            function ($attribute, $value, $fail) {
                if (! $value instanceof UploadedFile) {
                    return;
                }

                $ext = strtolower($value->getClientOriginalExtension());
                if (! in_array($ext, self::EXTENSIONS, true)) {
                    $fail('Only JPG, PNG, WEBP or GIF images are allowed.');
                }
            },
        ];

        // Content check only when PHP can do it (needs the fileinfo extension).
        if (extension_loaded('fileinfo')) {
            $imageRules[] = 'image';
        }

        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'distance_km' => ['required', 'numeric', 'min:0', 'max:999.99'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'facilities' => ['nullable', 'string'],
            'safety_info' => ['nullable', 'string'],
            'opening_hours' => ['nullable', 'string', 'max:255'],
            'entrance_fee' => ['nullable', 'string', 'max:255'],
            'accessibility' => ['nullable', 'string', 'max:5000'],
            'travel_tips' => ['nullable', 'string', 'max:5000'],
            // Optional: a full URL (https://...) or a local path like images/places/thotas.png
            'image_path' => ['nullable', 'string', 'max:500', 'regex:' . self::PATH_REGEX],
            'image_file' => $imageRules,
            'gallery_links' => ['nullable', 'string', 'max:5000'],
            'gallery' => ['nullable', 'array', 'max:20'],
            'gallery.*' => array_slice($imageRules, 1), // same rules, "nullable" not needed per item
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['integer'],
        ], [
            'image_path.regex' => 'Main image: use a full URL (https://...) or a path like images/places/thotas.png',
            'image_file.uploaded' => 'The main image could not be uploaded. It is probably too big for your PHP settings. Try a smaller photo.',
            'gallery.*.uploaded' => 'A gallery photo could not be uploaded. It is probably too big for your PHP settings. Try a smaller photo.',
            'image_file.max' => 'The main image must be 10 MB or smaller.',
            'gallery.*.max' => 'Each gallery photo must be 10 MB or smaller.',
            'image_file.image' => 'The main image must be a picture file.',
            'gallery.*.image' => 'Each gallery file must be a picture file.',
            'gallery.max' => 'You can add at most 20 gallery photos at a time.',
        ]);

        $this->galleryLinks = $this->parseGalleryLinks((string) $request->input('gallery_links'));

        unset(
            $data['image_path'], $data['image_file'], $data['gallery_links'],
            $data['gallery'], $data['remove_images']
        );

        return $data;
    }

    private function normalisePath(?string $path): ?string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        if (! preg_match('#^https?://#i', $path)) {
            $path = ltrim(str_replace('\\', '/', $path), '/');
        }

        return $path;
    }

    private function parseGalleryLinks(string $text): array
    {
        $links = [];

        foreach (preg_split('/\r\n|\r|\n/', $text) as $line) {
            $line = $this->normalisePath($line);

            if ($line === null) {
                continue;
            }

            if (! preg_match(self::PATH_REGEX, $line)) {
                throw ValidationException::withMessages([
                    'gallery_links' => "Invalid gallery link: {$line}  (use https://... or images/places/name.jpg)",
                ]);
            }

            $links[$line] = $line;
        }

        return array_values($links);
    }

 
    private function resolveImage(Request $request, ?Place $place): ?string
    {
        if ($request->hasFile('image_file')) {
            return $this->storeUpload($request->file('image_file'));
        }

        if ($path = $request->input('image_path')) {
            return $path;
        }

        return $place?->image;
    }

    private function saveGallery(Request $request, Place $place): void
    {
        foreach ((array) $request->file('gallery', []) as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $place->images()->create(['path' => $this->storeUpload($file)]);
            }
        }

        foreach ($this->galleryLinks as $link) {
            $place->images()->create(['path' => $link]);
        }
    }

    private function removeGalleryImages(Request $request, Place $place): void
    {
        $ids = $request->input('remove_images', []);

        if (! $ids) {
            return;
        }

        $images = $place->images()->whereIn('id', $ids)->get();
        $paths = $images->pluck('path')->all();

        PlaceImage::whereIn('id', $images->pluck('id'))->delete();

        foreach ($paths as $path) {
            $this->deleteFileIfUnused($path);
        }
    }

    private function storeUpload(UploadedFile $file): string
    {
        $ext = strtolower($file->getClientOriginalExtension());

        if (! in_array($ext, self::EXTENSIONS, true)) {
            $ext = 'jpg';
        }

        $name = 'place_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;

        $dir = public_path(self::IMAGE_DIR);
        if (! is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

        $file->move($dir, $name);

        return self::IMAGE_DIR . '/' . $name;
    }

    
    private function deleteFileIfUnused(?string $path): void
    {
        if (! $path || ! str_starts_with($path, self::IMAGE_DIR . '/')) {
            return;
        }

        if (Place::where('image', $path)->exists()
            || PlaceImage::where('path', $path)->exists()) {
            return;
        }

        
        $full = public_path(self::IMAGE_DIR . '/' . basename($path));

        if (is_file($full)) {
            @unlink($full);
        }
    }
}
