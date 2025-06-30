<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Redemptions;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RewardPoint;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{

    public function store(Request $request)
    {

        $validated = $request->validate([
            'price' => 'required|numeric',
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'points_required' => 'required|numeric',
            'description' => 'required|string|max:255'
        ]);

        // check if the product already exists
        if (Product::where('name', $validated['name'])->exists()) {
            return response()->json([
                'message' => 'A product with this name already exists.'
            ], 409);
        }

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created successfully.',
            'data' => $product,
        ], 201);
    }


    public function destroy($product_id)
    {
        $product = Product::find($product_id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sorry, product with ID ' . $product_id . ' does not exist.'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully.'
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product Not found'], 404);
        }

        if (Product::where('name', $validated['name'])->exists()) {
            return response()->json([
                'message' => 'A product with this name already exists.'
            ], 409);
        }

        $product->update($validated);

        return response()->json(['message' => 'Product updated successfully']);
    }




    public function redeem(Request $request, $product_id)
    {

        $user = auth()->user();

        $product = Product::where('id', $product_id)->whereHas('offerPool')->first();
        if (!$product) {
            return response()->json(['error' => 'Product not found or not in offerpool'], 404);
        }
        $userPoints = RewardPoint::firstWhere('user_id', $user->id);

        if (!$userPoints || $userPoints->points < $product->points_required) {
            return response()->json(['error' => 'user doesnt have enough points'], 400);
        }

        $userPoints->decrement('points', $product->points_required);

        Redemptions::create([
            'user_id' => $user->id,
            'product_id' =>  $product_id
        ]);
        $updatedUserPoints = RewardPoint::firstWhere('user_id', $user->id);

        return response()->json([
            'message' => 'product redeemed successfuly',
            'product' => $product->name,
            'Remaining Points' => $updatedUserPoints
        ], 200);
    }

    public function search(Request $request)
    {
        $query = $request->query('query');

        $products = Product::with('category')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhereHas('category', function ($q2) use ($query) {
                        $q2->where('name', 'like', "%{$query}%");
                    });
            })
            ->paginate(10);

        return response()->json([
            'results' => $products->items(),
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ]
        ]);
    }
}
