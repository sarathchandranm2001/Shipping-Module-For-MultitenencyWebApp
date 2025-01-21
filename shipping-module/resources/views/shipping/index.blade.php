<!-- resources/views/shipping/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Shipping Methods</h1>
    <a href="{{ route('shipping.create') }}" class="btn btn-primary mb-3">Add Shipping Method</a>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Type</th>
                <th>Flat Rate</th>
                <th>Service Timings</th>
                <th>Hyper Local</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($methods as $method)
                <tr>
                    <td>{{ $method->id }}</td>
                    <td>{{ $method->name }}</td>
                    <td>{{ ucfirst($method->type) }}</td>
                    <td>{{ $method->flat_rate ?? 'N/A' }}</td>
                    <td>
                        @if ($method->service_start && $method->service_end)
                            {{ $method->service_start }} - {{ $method->service_end }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $method->is_hyper_local ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('shipping.edit', $method->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('shipping.destroy', $method->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
