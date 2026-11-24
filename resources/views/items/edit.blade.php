@extends('layouts.app')

@section('title', 'Edit Item')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">POS Inventory</p>
            <h1>Edit Item</h1>

            <p class="description">
                Update item information, price, and stock.
            </p>
        </div>
    </section>

    <section class="card form-card">
        <form
            method="POST"
            action="{{ route('items.update', $item) }}"
        >
            @csrf
            @method('PUT')

            @include('items._form', ['item' => $item])

            <div class="form-actions">
                <button type="submit" class="button">
                    Update Item
                </button>

                <a
                    href="{{ route('items.index') }}"
                    class="button secondary"
                >
                    Cancel
                </a>
            </div>
        </form>
    </section>
@endsection