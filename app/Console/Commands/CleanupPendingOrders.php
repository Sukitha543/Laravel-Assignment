<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupPendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-pending-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup pending orders older than 30 minutes and restore stock';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expirationTime = \Carbon\Carbon::now()->subMinutes(30);

        $expiredOrders = \App\Models\Order::where('status', 'pending')
            ->where('created_at', '<', $expirationTime)
            ->with('items')
            ->get();

        $count = 0;

        foreach ($expiredOrders as $order) {
            
            // Restore Stock
            foreach ($order->items as $item) {
                $product = \App\Models\Product::find($item->product_id);
                if ($product) {
                    $product->quantity += $item->quantity;
                    $product->save();
                }
            }

            $order->delete();
            $count++;
        }

        $this->info("Cleaned up {$count} expired pending orders.");
    }
}
