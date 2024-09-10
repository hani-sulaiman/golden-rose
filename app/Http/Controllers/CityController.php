<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
        // Get all cities
        public function index()
        {
            $cities = City::all();
            return response()->json($cities);
        }
    
        // Create a new city
        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
    
            $city = City::create([
                'name' => $request->name,
            ]);
    
            return response()->json($city, 201);
        }
        // Update a city
        public function update(Request $request, $id)
        {
            $city = City::findOrFail($id);
    
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
    
            $city->update([
                'name' => $request->name,
            ]);
    
            return response()->json($city);
        }
    
        // Delete a city
        public function destroy($id)
        {
            $city = City::findOrFail($id);
            $city->delete();
    
            return response()->json(null, 204);
        }
}
