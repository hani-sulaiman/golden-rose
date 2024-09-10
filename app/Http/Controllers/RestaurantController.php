<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with('city')->get();
        return response()->json($restaurants);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ]);

        $restaurant = Restaurant::create([
            'name' => $request->name,
            'city_id' => $request->city_id,
        ]);

        return response()->json($restaurant, 201);
    }

    public function show($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return response()->json($restaurant);
    }

    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ]);

        $restaurant->update([
            'name' => $request->name,
            'city_id' => $request->city_id,
        ]);

        return response()->json($restaurant);
    }

    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->delete();

        return response()->json(null, 204);
    }
}
