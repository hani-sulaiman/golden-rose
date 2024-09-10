<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use App\Models\TravelImage;
use App\Models\UserTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class TravelController extends Controller
{
    public function index()
    {
        $travels = Travel::with(['hotel', 'restaurant', 'category', 'images'])->get();
        return response()->json($travels);
    }
    
    public function registeredUsers()
    {
        $registrations = UserTravel::with(['user', 'travel'])->get();

        $formattedRegistrations = $registrations->map(function ($registration) {
            return [
                'user_fullname' => $registration->user->fullname,
                'user_email' => $registration->user->email,
                'travel_name' => $registration->travel->name,
                'is_paid' => $registration->is_paid ? 'Paid' : 'Not Paid',
            ];
        });

        return response()->json($formattedRegistrations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'restaurant_id' => 'nullable|exists:restaurants,id',
            'hotel_id' => 'nullable|exists:hotels,id',
            'cost' => 'required|numeric',
            'is_group' => 'required|boolean',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'category_id' => 'required|exists:categories,id',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image',
        ]);

    
        $travel = Travel::create($request->only([
            'name', 'restaurant_id', 'hotel_id', 'cost', 'is_group', 'start_date', 'end_date', 'category_id'
        ]));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/travel_images'), $imageName);

                TravelImage::create([
                    'travel_id' => $travel->id,
                    'image_path' => 'uploads/travel_images/' . $imageName,
                ]);
            }
        }


        return response()->json($travel->load('images'), 201);
    }
    public function show($id)
    {
        $travel = Travel::with(['hotel', 'restaurant', 'category', 'images'])->findOrFail($id);
        return response()->json($travel);
    }
    

    public function destroy($id)
    {
        $travel = Travel::findOrFail($id);
        $images = $travel->images;
        foreach ($images as $image) {
            $imagePath = public_path($image->image_path);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $travel->delete();
        return response()->json(['message' => 'Travel and associated images deleted successfully'], 200);
    }
}
