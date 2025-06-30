<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\CreditPackage;
use App\Models\RewardPoint;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:credit_packages,id',
        ]);

        $package = CreditPackage::findorFail($request->package_id);

        $user = User::find(1);

        // Create purchase record
        $purchase = Purchase::create([
            'user_id' =>   $user->id,
            'credit_package_id' => $package->id,
        ]);

        // Update user credits

        $user->credits += $package->credits;
        $user->save();

        //Add Reward Points
        $reward = RewardPoint::firstOrCreate(
            ['user_id' => $user->id],
            ['points' => 0]
        );

        $reward->increment('points', $package->reward_points);

        return response()->json(['message' => 'Purchase successful'],200);
    }
}
