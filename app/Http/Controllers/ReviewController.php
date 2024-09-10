<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ReviewController extends Controller
{
    // Submit a review for a travel
    public function store(Request $request, $travelId)
    {
    
        $request->validate([
            'comment' => 'nullable|string',
            'rate' => 'required|min:1|max:10',
        ]);

        $user = Auth::user();
        $travel = Travel::findOrFail($travelId);

        // Create the review
        Review::create([
            'user_id' => $user->id,
            'travel_id' => $travelId,
            'comment' => $request->input('comment'),
            'rate' => $request->input('rate'),
        ]);

        return response()->json(['message' => 'Review submitted successfully']);
    }

    // View all reviews for a travel
    public function index($travelId)
    {
        $reviews = Review::where('travel_id', $travelId)->with('user')->get();
        return response()->json($reviews);
    }
}
