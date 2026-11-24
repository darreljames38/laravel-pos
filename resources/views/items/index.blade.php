@extends('layouts.app')

@section('title', 'POS Items')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">POS Inventory</p>
            <h1>Items</h1>

            <p class="description">
                Manage products, prices, stock, and availability.
            </p>
        </div>

        <a href="{{ route('items.create') }}" class="button">
            New Item
        </a>
    </section>

    @if (session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $item->sku }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category }}</td>

                        <td>
                            ₱{{ number_format($item->selling_price, 2) }}
                        </td>

                        <td>{{ $item->stock_quantity }}</td>

                        <td>
                            <span class="status {{ $item->status }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>

                        <td>
                            <div class="table-actions">
                                <a
                                    href="{{ route('items.show', $item) }}"
                                    class="button small secondary"
                                >
                                    View
                                </a>

                                <a
                                    href="{{ route('items.edit', $item) }}"
                                    class="button small secondary"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('items.destroy', $item) }}"
                                    onsubmit="return confirm(
                                        'Delete this item permanently?'
                                    );"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="button small danger"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            No items have been created yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection