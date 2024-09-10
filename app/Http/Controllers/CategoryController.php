<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // Create a new category
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create the category
        $category = Category::create([
            'name' => $request->name,
        ]);

        // Return a success response
        return response()->json($category, 201);
    }

    // Update an existing category
    public function update(Request $request, $id)
    {
        // Find the category by ID
        $category = Category::findOrFail($id);

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the category
        $category->update([
            'name' => $request->name,
        ]);

        // Return the updated category
        return response()->json($category);
    }

    // Delete a category
    public function destroy($id)
    {
        // Find the category by ID
        $category = Category::findOrFail($id);

        // Delete the category
        $category->delete();

        // Return a success response
        return response()->json(null, 204);
    }
}
