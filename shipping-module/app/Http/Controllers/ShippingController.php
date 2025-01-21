<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
{
    $methods = ShippingMethod::all();
    return view('shipping.index', compact('methods'));
}

public function create()
{
    return view('shipping.form');
}

public function store(Request $request)
{
    ShippingMethod::create($request->all());
    return redirect()->route('shipping.index')->with('success', 'Shipping Method added successfully!');
}

public function edit($id)
{
    $method = ShippingMethod::findOrFail($id);
    return view('shipping.form', compact('method'));
}

public function update(Request $request, $id)
{
    $method = ShippingMethod::findOrFail($id);
    $method->update($request->all());
    return redirect()->route('shipping.index')->with('success', 'Shipping Method updated successfully!');
}

public function destroy($id)
{
    ShippingMethod::destroy($id);
    return redirect()->route('shipping.index')->with('success', 'Shipping Method deleted successfully!');
}

    // Get available shipping methods
    public function getShippingMethods()
    {
        $methods = ShippingMethod::all();
        return response()->json($methods);
    }

    // Calculate shipping cost
    public function calculateShipping(Request $request)
    {
        $method = ShippingMethod::find($request->shipping_method_id);

        if (!$method) {
            return response()->json(['error' => 'Shipping method not found'], 404);
        }

        $cost = 0;
        if ($method->type === 'self-shipped') {
            $cost = $method->flat_rate;
        } elseif ($method->type === 'auto-shipped') {
            $cost = $this->calculateAutoShipping($method, $request->weight, $request->destination);
        }

        return response()->json(['cost' => $cost]);
    }

    private function calculateAutoShipping($method, $weight, $destination)
    {
        // Placeholder for integration with external APIs like DHL or FedEx
        return 15.00; // Mocked cost
    }

    // Get tracking details
    public function getTrackingDetails($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->shippingMethod->type === 'auto-shipped') {
            // Call external API for tracking (placeholder)
            return response()->json([
                'tracking_id' => $order->tracking_id,
                'status' => 'In Transit',
                'estimated_delivery' => now()->addDays(2),
            ]);
        }

        return response()->json($order->trackingDetails);
    }
}
