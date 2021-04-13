<?php


namespace Combindma\Gallery\Http\Controllers;



use Combindma\Gallery\Http\Requests\GalleryRequest;
use Combindma\Gallery\Models\Gallery;

class GalleryCategoryController
{
    public function index()
    {
        $gallery = Gallery::with('media')->latest()->paginate(12);
        return view('gallery::index', compact('gallery'));
    }

    public function store(GalleryRequest $request)
    {
        $gallery = Gallery::create([]);
        // Add Media
        $gallery->addImage($request->file('image'));
        flash('Ajout effectué avec succès');
        return redirect()->route('gallery::gallery.index');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        flash('Media supprimé avec succès');
        return back();
    }
}
