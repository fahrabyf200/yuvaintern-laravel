<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json([
            'success' => true,
            'message' => 'Products retrieved successfully',
            'data' => ProductResource::collection($products),
        ], 200);
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'category_id' => ['required', 'exists:categories,id'],
        'name' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'price' => ['required', 'numeric', 'min:0'],
        'stock' => ['required', 'integer', 'min:0'],
    ]);

    $product = Product::create($validated);
    $product->load('category');
    
    return response()->json([
        'success' => true,
        'message' => 'Product created successfully',
        'data' => new ProductResource($product),
    ], 201);
}
public function show(Product $product)
{
    $product->load('category');

    return response()->json([
        'success' => true,
        'message' => 'Product retrieved successfully',
        'data' => new ProductResource($product),
    ], 200);
}
public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'category_id' => ['required', 'exists:categories,id'],
        'name' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'price' => ['required', 'numeric', 'min:0'],
        'stock' => ['required', 'integer', 'min:0'],
    ]);

    $product->update($validated);
    $product->load('category');


    return response()->json([
        'success' => true,
        'message' => 'Product updated successfully',
        'data' => new ProductResource($product),
    ], 200);
}

public function destroy(Product $product)
{
    $product->delete();

    return response()->json([
        'success' => true,
        'message' => 'Product deleted successfully',
    ], 200);
}
}
