<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    public function captureImage(Request $request)
    {
        // Validate incoming request if needed
// return $request;
        // Get the image data from the request
        $imageData = $request->input('image_data');

        // Save the image to the database
        $image = new Image();
        $image->user_id = Auth::id();
        $image->image_path = $this->saveImageFromBase64($imageData);
        $image->save();

        return response()->json(['message' => 'Image captured and saved successfully.']);
    }

    public function uploadImage(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size if needed
        ]);

        // Check if file exists in the request
        if ($request->hasFile('image')) {
            // Get the uploaded file
            $uploadedFile = $request->file('image');

            // Save the uploaded image to the database
            $image = new Image();
            $image->user_id = Auth::id();
            $image->image_path = $uploadedFile->store('images'); // Adjust storage path if needed
            $image->save();

            return response()->json(['message' => 'Image uploaded successfully.']);
        } else {
            return response()->json(['error' => 'No file uploaded.'], 400);
        }
    }


    private function saveImageFromBase64($imageData)
    {
        // Decode base64 image data and save to storage
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
        $imageName = 'image_' . time() . '.png'; // Generate a unique image name
        file_put_contents(public_path('images/' . $imageName), $image);

        return 'images/' . $imageName;
    }

    private function saveImageFromFile($uploadedFile)
    {
        // Save uploaded file to storage
        $imageName = $uploadedFile->getClientOriginalName();
        $uploadedFile->move(public_path('images'), $imageName);

        return 'images/' . $imageName;
    }
}
