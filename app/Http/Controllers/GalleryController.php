<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::with('user')->latest()->paginate(20);
        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Display gallery images for resources section with zoom functionality
     */
    public function resources()
    {
        $galleries = Gallery::with('user')->latest()->paginate(24);
        return view('admin.resources.gallery', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if file exists - try both 'image' and 'file' parameter names
        $file = $request->file('image') ?? $request->file('file');
        
        if (!$file) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json(['error' => 'The image field is required.'], 422);
            }
            return back()->withErrors(['image' => 'The image field is required.']);
        }
        
        // Validate the file
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], [
            'image.required' => 'Please select an image to upload.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
            'image.max' => 'The image may not be greater than 10MB.',
        ]);
        
        // Get file after validation - ensure we have it
        $file = $request->file('image');
        if (!$file) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json(['error' => 'Failed to process the uploaded file.'], 422);
            }
            return back()->withErrors(['image' => 'Failed to process the uploaded file.']);
        }
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('gallery', $filename, 'public');

        $gallery = Gallery::create([
            'title' => $validated['title'] ?? $file->getClientOriginalName(),
            'image_path' => $path,
            'description' => $validated['description'] ?? null,
            'user_id' => auth()->id(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully',
                'gallery' => $gallery,
                'url' => asset('storage/' . $path),
            ]);
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Image uploaded successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $gallery = Gallery::findOrFail($id);

        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $validated['image_path'] = $file->storeAs('gallery', $filename, 'public');
        }

        $updateData = [
            'title' => $validated['title'] ?? $gallery->title,
            'image_path' => $validated['image_path'] ?? $gallery->image_path,
        ];
        
        // Only update description if it was provided
        if (isset($validated['description'])) {
            $updateData['description'] = $validated['description'];
        } else {
            $updateData['description'] = $gallery->description;
        }
        
        $gallery->update($updateData);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        
        // Delete the file
        if (Storage::disk('public')->exists($gallery->image_path)) {
            Storage::disk('public')->delete($gallery->image_path);
        }
        
        $gallery->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully',
            ]);
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Image deleted successfully.');
    }
}
