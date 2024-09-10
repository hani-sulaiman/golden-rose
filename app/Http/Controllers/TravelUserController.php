<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use App\Models\UserTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelUserController extends Controller
{
    public function index()
    {
        $travels = Travel::with(['hotel', 'restaurant', 'category', 'images'])->get();
        return response()->json($travels);
    }
    
    public function travelsByCategory($categoryId)
    {
        $travels = Travel::where('category_id', $categoryId)->with(['hotel', 'restaurant', 'category', 'images'])->get();
        return response()->json($travels);
    }
    public function searchTravels(Request $request)
    {
        $query = $request->input('query');
        $travels = Travel::where('name', 'like', '%' . $query . '%')->with(['hotel', 'restaurant', 'category', 'images'])->get();
        return response()->json($travels);
    }

    public function show($id)
    {
        $travel = Travel::with(['hotel', 'restaurant', 'category', 'images'])->findOrFail($id);
        return response()->json($travel);
    }
    
    

    public function registerTravel(Request $request, $id)
    {
        $travel = Travel::findOrFail($id);
        $user = Auth::user();

        if (UserTravel::where('user_id', $user->id)->where('travel_id', $id)->exists()) {
            return response()->json(['message' => 'You are already registered for this travel'], 409);
        }

        UserTravel::create([
            'user_id' => $user->id,
            'travel_id' => $id,
            'is_paid' => $request->input('is_paid', 1),
        ]);

        return response()->json(['message' => 'Registered successfully']);
    }

    public function registeredTravels()
    {
        $user = Auth::user();
    
        $travels = $user->travels()->with(['hotel', 'restaurant', 'category', 'images'])->get();
    
        return response()->json($travels);
    }
    public function review_average($id)
    {
        // Find the travel by ID
        $travel = Travel::with('reviews.user')->findOrFail($id);

        // Get the reviews
        $reviews = $travel->reviews;

        // Calculate the average rating (0 to 10 scale)
        $average_rating = $reviews->avg('rate');

        // If there are no reviews, set average to null
        if ($reviews->isEmpty()) {
            $average_rating = null;
        } else {
            $average_rating = round($average_rating, 2); // round to 2 decimal places
        }

        // Prepare the response with average rating and comments
        $response = [
            'travel' => $travel->name,
            'average_rating' => $average_rating,
            'reviews' => $reviews->map(function ($review) {
                return [
                    'user' => $review->user->fullname,
                    'comment' => $review->comment,
                    'rate' => (float) $review->rate, // cast to float to ensure float value
                ];
            })
        ];

        return response()->json($response);
    }
}
