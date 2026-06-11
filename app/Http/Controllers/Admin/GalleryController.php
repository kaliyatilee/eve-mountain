<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryImage::orderBy('sort_order')->get();
        return view('admin.gallery.index', compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'images'          => 'required|array|min:1',
            'images.*'        => 'image|mimes:jpeg,png,jpg,webp|max:8192',
            'caption'         => 'nullable|string|max:200',
            'category'        => 'required|in:general,dorms,activities,facilities,outdoor',
        ]);

        $maxOrder = GalleryImage::max('sort_order') ?? 0;

        foreach ($request->file('images') as $file) {
            $filename = uniqid('img_') . '.' . $file->getClientOriginalExtension();

            // Save full-size (max 1920px wide)
            $img = Image::make($file)->resize(1920, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            Storage::disk('public')->put('gallery/' . $filename, (string) $img->encode());

            // Save thumbnail (400px wide)
            $thumb = Image::make($file)->resize(400, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            Storage::disk('public')->makeDirectory('gallery/thumbs');
            Storage::disk('public')->put('gallery/thumbs/' . $filename, (string) $thumb->encode());

            GalleryImage::create([
                'filename'   => $filename,
                'caption'    => $request->caption,
                'category'   => $request->category,
                'sort_order' => ++$maxOrder,
                'is_visible' => true,
            ]);
        }

        return back()->with('success', count($request->file('images')) . ' image(s) uploaded.');
    }

    public function update(Request $request, GalleryImage $galleryImage)
    {
        $request->validate([
            'caption'    => 'nullable|string|max:200',
            'category'   => 'required|in:general,dorms,activities,facilities,outdoor',
            'is_visible' => 'nullable|boolean',
        ]);

        $galleryImage->update([
            'caption'    => $request->caption,
            'category'   => $request->category,
            'is_visible' => $request->boolean('is_visible'),
        ]);

        return back()->with('success', 'Image updated.');
    }

    public function destroy(GalleryImage $galleryImage)
    {
        Storage::disk('public')->delete('gallery/' . $galleryImage->filename);
        Storage::disk('public')->delete('gallery/thumbs/' . $galleryImage->filename);
        $galleryImage->delete();

        return back()->with('success', 'Image deleted.');
    }

    /**
     * AJAX: Save new sort order after drag-and-drop
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer|exists:gallery_images,id',
        ]);

        foreach ($request->order as $position => $id) {
            GalleryImage::where('id', $id)->update(['sort_order' => $position]);
        }

        return response()->json(['success' => true]);
    }
}
