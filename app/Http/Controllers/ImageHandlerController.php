<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ImageHandlerController extends Controller
{
    public function imageUpload(Request $request)
    {
        // Validate the uploaded file  
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle the file upload and store it in the desired location
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName); // Store the image in the storage/app/public/images directory
            

            // Delete the old profile picture if it exists
            if (auth()->user()->profile_image) {
                Storage::delete('public/' . auth()->user()->profile_image);
            }
            // Update the user's profile with the new image
            auth()->user()->update(['profile_image' => 'images/' . $imageName]);
        }
        return Inertia::render('Profile/Main', [
            'success' => true, // Pass the success state to the component
        ]);
    }
    protected function deleteImage(){
        // Delete the old profile picture if it exists
        if (auth()->user()->profile_image) {
            Storage::delete('public/' . auth()->user()->profile_image);
        }
        // Update the user's profile with the new image
        auth()->user()->update(['profile_image' => null]);
        return Inertia::render('Profile/Main', [
            'success' => true, // Pass the success state to the component
        ]);
    }
}