<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIController extends Controller
{


    public function recommend(Request $request)
    {
        $user = User::find($request->user()->id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $userPoints = $user->rewardPoints->points ?? 0;

        $products = Product::whereHas('offerPool')->get();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products in offer pool'], 200);
        }

        // Build prompt
        $prompt = "A user has {$userPoints} reward points. These are the products in the offer pool:\n";
        foreach ($products as $product) {
            $prompt .= "- {$product->name} ({$product->points_required} points): {$product->description}\n";
        }
        $prompt .= "\nWhich product would you recommend the user redeem based on their balance? Respond with only the product name.";

        Log::info("AI Prompt:\n" . $prompt);

        try {
            $response = Http::withToken(env('OPENAI_API_KEY'))
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful recommendation engine.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'temperature' => 0.7,
                ]);

            $responseData = $response->json();

            if (isset($responseData['error'])) {
                Log::warning('OpenAI API error: ' . json_encode($responseData['error']));
                throw new \Exception($responseData['error']['message']);
            }

            $recommended = $responseData['choices'][0]['message']['content'] ?? 'No recommendation available.';
        } catch (\Throwable $e) {
            
            // Fallback: recommend the best product user can afford
            Log::error('AI recommendation failed: ' . $e->getMessage());

            $fallback = $products
                ->where('points_required', '<=', $userPoints)
                ->sortByDesc('points_required')
                ->first();

            $recommended = $fallback ? $fallback->name . ' (fallback)' : 'No recommendation available.';
        }

        return response()->json([
            'recommended_product' => $recommended,
            'available_points' => $userPoints,
        ]);
    }
}
