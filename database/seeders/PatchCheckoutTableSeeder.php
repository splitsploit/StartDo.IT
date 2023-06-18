<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Checkout;

class PatchCheckoutTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // first method
        // $checkouts = Checkout::whereTotal(0)->get();

        // second method
        $checkouts = Checkout::where('total', 0)->get();
        foreach ($checkouts as $key => $checkout) {
            $checkout->update([
                'total' => $checkout->camp->price * 1000,
            ]);
        }
    }
}
