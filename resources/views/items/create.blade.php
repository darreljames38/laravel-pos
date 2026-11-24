@extends('layouts.app')

@section('title', 'Create Item')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">POS Inventory</p>
            <h1>Create Item</h1>

            <p class="description">
                Add a new product to the POS inventory.
            </p>
        </div>
    </section>

    <section class="card form-card">
        <form method="POST" action="{{ route('items.store') }}">
            @csrf

            @include('items._form', ['item' => null])

            <div class="form-actions">
                <button type="submit" class="button">
                    Create Item
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