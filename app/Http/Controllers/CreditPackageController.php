<?php

namespace App\Http\Controllers;

use App\Models\CreditPackage;
use Illuminate\Http\Request;

class CreditPackageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'reward_points' => ['required', 'numeric'],
            'credits' => ['required', 'numeric'],
        ]);

        // check if the credit package already exists
        if (CreditPackage::where('name', $validated['name'])->exists()) {
            return response()->json([
                'message' => 'A credit package with this name already exists.'
            ], 409);
        }

        $credit_package = CreditPackage::create($validated);

        return response()->json([
            'message' => 'Credit package created successfully.',
            'data' => $credit_package,
        ], 201);
    }


    public function update(Request $request, $credit_package_id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'reward_points' => ['required', 'numeric'],
            'credits' => ['required', 'numeric'],
        ]);

        $creditPackage = CreditPackage::find($credit_package_id);

        if (!$creditPackage) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sorry, credit package with ID ' . $credit_package_id . ' does not exist.'
            ], 404);
        }

         if (CreditPackage::where('name', $validated['name'])->exists()) {
            return response()->json([
                'message' => 'A credit package with this name already exists.'
            ], 409);
        }

        $creditPackage->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Credit Package updated successfully.'
        ], 200);
    }


    public function destroy($credit_package_id)
    {
        $creditPackage = CreditPackage::find($credit_package_id);

        if (!$creditPackage) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sorry, credit package with ID ' . $credit_package_id . ' does not exist.'
            ], 404);
        }

        $creditPackage->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Credit Package deleted successfully.'
        ], 200);
    }
}
