<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $galleries = Gallery::all();
        return view('backend.gallery.index', compact('galleries', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        return view('backend.gallery.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'path' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:8192',
        ]);

        $imageName = null;

        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(('uploads/gallerys'), $imageName);
        }

        Gallery::create([
            'path' => 'uploads/gallerys/' . $imageName,
        ]);

        return redirect()->route('gallery.index')->with('success', 'Gallery created successfully.');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $gallery = Gallery::findOrFail($id);
        return view('backend.gallery.edit', compact('gallery', 'user'));
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8192',
        ]);

        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(('uploads/gallerys'), $imageName);

            if ($gallery->path) {
                @unlink(($gallery->path));
            }

            $gallery->path = 'uploads/gallerys/' . $imageName;
        }

        $gallery->save();

        return redirect()->route('gallery.index')->with('success', 'Gallery updated successfully.');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($gallery->path && file_exists(($gallery->path))) {
            unlink(($gallery->path));
        }

        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Gallery deleted successfully.');
    }
}
