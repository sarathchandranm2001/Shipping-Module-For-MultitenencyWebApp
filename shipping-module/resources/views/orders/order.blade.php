<!-- resources/views/orders/tracking.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Tracking Details for Order #{{ $order->order_number }}</h1>

    @if ($order->shippingMethod->type === 'auto-shipped')
        <p><strong>Tracking ID:</strong> {{ $tracking['tracking_id'] }}</p>
        <p><strong>Status:</strong> {{ $tracking['status'] }}</p>
        <p><strong>Estimated Delivery:</strong> {{ $tracking['estimated_delivery'] }}</p>
    @else
        <ul>
            @foreach ($order->trackingDetails as $detail)
                <li>{{ $detail->status }} - {{ $detail->created_at }}</li>
            @endforeach
        </ul>
    @endif
@endsection
