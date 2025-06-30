<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'sherif@4sale.com',
            'is_admin' => true,
            'password' => Hash::make('sherif123'),
        ]);

        $this->call(CreditPackageSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
