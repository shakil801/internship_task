<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // Fetch all products with categories and features
        $products = Product::with(['categories', 'features'])->get();

        return response()->json($products);
    }
}
