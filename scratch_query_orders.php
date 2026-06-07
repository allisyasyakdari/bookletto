<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

// In Laravel 11, the app might be bootstrapped slightly differently for console commands, 
// but we can bootstrap it by handling a console command or manually boot providers.
$app->boot();

$orders = App\Models\Order::orderByDesc('created_at')->take(5)->get();
foreach ($orders as $order) {
    echo "Order #{$order->id} | Subtotal: {$order->subtotal} | Discount: {$order->discount_amount} | Promo: {$order->promo_code} | Total: {$order->total} | Created: {$order->created_at}\n";
}
