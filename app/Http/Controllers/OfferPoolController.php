<?php

namespace App\Http\Controllers;

use App\Models\OfferPool;
use App\Models\Product;
use App\Models\Redemptions;
use Illuminate\Http\Request;

class OfferPoolController extends Controller
{
    public function store($product_id)
    {
        $product = Product::find($product_id);

        if (!$product) {
            return response()->json(["error" => "The Product is not found"], 404);
        }

        $alreadyInPool = OfferPool::where('product_id', $product_id)->exists();

        if ($alreadyInPool) {
            return response()->json(["message" => "Product is already in the offer pool"], 200);
        }

        OfferPool::create([
            'product_id' => $product_id
        ]);

        return response()->json(['message' => "Product Added to offerpool successfuly"],201);
    }

    public function destroy($product_id)
    {
        $offer = OfferPool::where('product_id', $product_id)->first();

        if (!$offer) {
            return response()->json(["error" => "The product is not in the offer pool"], 404);
        }

        $offer->delete();

        return response()->json(['message' => "Product removed from offer pool successfully"],200);
    }
}
