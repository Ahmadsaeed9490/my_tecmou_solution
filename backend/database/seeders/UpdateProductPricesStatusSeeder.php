<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductPrice;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class UpdateProductPricesStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting to update product prices status...');

        try {
            // Get all product prices
            $productPrices = ProductPrice::with('product')->get();
            $updatedCount = 0;

            foreach ($productPrices as $price) {
                $oldStatus = $price->status;
                
                if ($price->product) {
                    // Set status based on product status and deletion state
                    $newStatus = ($price->product->status && !$price->product->deleted_at) ? 1 : 0;
                    
                    if ($price->status !== $newStatus) {
                        $price->status = $newStatus;
                        $price->save();
                        $updatedCount++;
                        
                        $this->command->info("Updated price ID {$price->id}: {$oldStatus} -> {$newStatus}");
                    }
                } else {
                    // If product doesn't exist, deactivate the price
                    if ($price->status !== 0) {
                        $price->status = 0;
                        $price->save();
                        $updatedCount++;
                        
                        $this->command->info("Deactivated orphaned price ID {$price->id} (no product)");
                    }
                }
            }

            $this->command->info("Successfully updated {$updatedCount} product prices.");
            
        } catch (\Exception $e) {
            $this->command->error("Error updating product prices: " . $e->getMessage());
        }
    }
}
