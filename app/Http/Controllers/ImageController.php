<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function addImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();
        $image->storeAs('images', $imageName, 'public');
        $imageUrl = Storage::url("images/$imageName");

        $newImage = Image::create(['url' => $imageUrl]);

        return response()->json(['url' => $newImage->url]);
    }

    public function getImages()
    {
        $images = Image::take(10)->get(['url']);
        return response()->json($images);
    }
}
