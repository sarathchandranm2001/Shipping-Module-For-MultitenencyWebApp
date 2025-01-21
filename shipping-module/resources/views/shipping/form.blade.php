<!-- resources/views/shipping/form.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>{{ isset($method) ? 'Edit' : 'Add' }} Shipping Method</h1>
    <form action="{{ isset($method) ? route('shipping.update', $method->id) : route('shipping.store') }}" method="POST">
        @csrf
        @if (isset($method))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $method->name ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" id="type" class="form-select" required>
                <option value="self-shipped" {{ (isset($method) && $method->type === 'self-shipped') ? 'selected' : '' }}>Self-Shipped</option>
                <option value="auto-shipped" {{ (isset($method) && $method->type === 'auto-shipped') ? 'selected' : '' }}>Auto-Shipped</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="flat_rate" class="form-label">Flat Rate</label>
            <input type="number" name="flat_rate" id="flat_rate" class="form-control" step="0.01" value="{{ $method->flat_rate ?? '' }}">
        </div>

        <div class="mb-3">
            <label for="service_start" class="form-label">Service Start</label>
            <input type="time" name="service_start" id="service_start" class="form-control" value="{{ $method->service_start ?? '' }}">
        </div>

        <div class="mb-3">
            <label for="service_end" class="form-label">Service End</label>
            <input type="time" name="service_end" id="service_end" class="form-control" value="{{ $method->service_end ?? '' }}">
        </div>

        <div class="mb-3">
            <label for="is_hyper_local" class="form-label">Hyper Local</label>
            <select name="is_hyper_local" id="is_hyper_local" class="form-select">
                <option value="1" {{ (isset($method) && $method->is_hyper_local) ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ (isset($method) && !$method->is_hyper_local) ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($method) ? 'Update' : 'Save' }}</button>
    </form>
@endsection
