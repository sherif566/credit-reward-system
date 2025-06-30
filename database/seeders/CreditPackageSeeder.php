<?php

namespace Database\Seeders;

use App\Models\CreditPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreditPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CreditPackage::create([
            'name' => 'Starter Pack',
            'price' => 100,
            'credits' => 100,
            'reward_points' => 10
        ]);

        CreditPackage::create([
            'name' => 'Pro Pack',
            'price' => 250 ,
            'credits' => 300,
            'reward_points' => 40
        ]);

    }
}
