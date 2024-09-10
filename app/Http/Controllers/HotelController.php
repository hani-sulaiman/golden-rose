<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::with('city')->get();
        return response()->json($hotels);
    }

    // Create a new hotel
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ]);

        $hotel = Hotel::create([
            'name' => $request->name,
            'city_id' => $request->city_id,
        ]);

        return response()->json($hotel, 201);
    }

    // Get a single hotel
    public function show($id)
    {
        $hotel = Hotel::with('city')->findOrFail($id);
        return response()->json($hotel);
    }

    // Update a hotel
    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ]);

        $hotel->update([
            'name' => $request->name,
            'city_id' => $request->city_id,
        ]);

        return response()->json($hotel);
    }

    // Delete a hotel
    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return response()->json(null, 204);
    }
}
