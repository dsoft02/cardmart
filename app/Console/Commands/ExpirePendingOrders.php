<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class ExpirePendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-pending-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduler To Handle Abandoned Pending Orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expired = Order::where('status', 'pending')
            ->where('created_at', '<', now()->subMinutes(config('orders.pending_expiry_minutes')))
            ->update(['status' => 'failed']);

        $this->info("Expired {$expired} pending orders.");
    }
}
