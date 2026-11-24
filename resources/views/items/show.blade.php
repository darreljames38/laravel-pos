@extends('layouts.app')

@section('title', $item->name)

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">POS Item</p>
            <h1>{{ $item->name }}</h1>

            <p class="description">
                SKU: {{ $item->sku }}
            </p>
        </div>
    </section>

    <section class="card">
        <p>
            <strong>Category:</strong>
            {{ $item->category }}
        </p>

        <p>
            <strong>Description:</strong>
            {{ $item->description ?: 'No description provided.' }}
        </p>

        <p>
            <strong>Selling Price:</strong>
            ₱{{ number_format($item->selling_price, 2) }}
        </p>

        <p>
            <strong>Stock Quantity:</strong>
            {{ $item->stock_quantity }}
        </p>

        <p>
            <strong>Status:</strong>
            {{ ucfirst($item->status) }}
        </p>

        <div class="form-actions">
            <a
                href="{{ route('items.edit', $item) }}"
                class="button"
            >
                Edit Item
            </a>

            <a
                href="{{ route('items.index') }}"
                class="button secondary"
            >
                Back to Items
            </a>
        </div>
    </section>
@endsection