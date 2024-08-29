<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        // Fetch all products with categories and features
        $products = Product::with(['categories', 'features'])->get();

        return response()->json($products);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
        ]);

        // Handle the image upload
        $imagePath = $request->file('image')->store('products', 'public');

        // Create the product
        $product = new Product();
        $product->name = $validated['name'];
        $product->image = $imagePath;
        $product->save();

        // Attach categories
        $product->categories()->attach($validated['categories']);
        // Save features if any
    if (!empty($validated['features'])) {
        foreach ($validated['features'] as  $description) {
            if (!empty($description)) {
                $product->features()->create(['description' => $description]);
            }
        }
    }

        return response()->json(['success' => 'Product uploaded successfully'], 201);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->input('name');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return response()->json(['success' => 'Product updated successfully']);
    }


    public function destroy($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Delete the product
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully!'
        ], 200);
    }
}
