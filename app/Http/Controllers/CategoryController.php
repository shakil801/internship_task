<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    { 
        $categories = Category::all();

        // Return the categories as a JSON response
        return response()->json([
            'success' => true,
            'data' => $categories
        ], 200);
    }

    public function store(Request $request){
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        //create a new category
        $category = new Category();
        $category->name = $validatedData['name'];
        $category->save();
        return redirect()->back()->with('success', 'Category added successfully!');
    }

    public function destroy($id)
    {
        // Find the category by ID
        $category = Category::find($id);

        if ($category) {
            // Delete all products associated with this category
           $category->products()->delete();

            // Delete the category
            $category->delete();
            
            return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
        } else {
            
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        }
    }
}
