<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display tracking details for an order.
     *
     * @param int $orderId
     * @return \Illuminate\View\View
     */
    public function showTracking($orderId)
    {
        // Fetch the order and its related shipping method
        $order = Order::with('shippingMethod')->findOrFail($orderId);

        // Check if the shipping method is Auto-Shipped or Self-Shipped
        if ($order->shippingMethod->type === 'auto-shipped') {
            // Call an external API for tracking (mock example here)
            $tracking = [
                'tracking_id' => '123456789',
                'status' => 'In Transit',
                'estimated_delivery' => '2025-01-25',
            ];
        } else {
            // Fetch internal tracking details (if self-shipped)
            $tracking = $order->trackingDetails; // Assumes a `trackingDetails` relationship
        }

        return view('orders.tracking', compact('order', 'tracking'));
    }
}
