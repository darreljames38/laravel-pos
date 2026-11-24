@extends('layouts.app')

@section('title', 'Receipt '.$sale->receipt_number)

@section('content')
    @if (session('success'))
        <div class="alert success no-print">
            {{ session('success') }}
        </div>
    @endif

    <section class="receipt-card">
        <header class="receipt-header">
            <p class="eyebrow">Point of Sale</p>
            <h1>Sales Receipt</h1>

            <p class="receipt-number">
                {{ $sale->receipt_number }}
            </p>
        </header>

        <div class="receipt-information">
            <div>
                <span>Date and Time</span>

                <strong>
                    {{ $sale->sold_at->format('F j, Y g:i A') }}
                </strong>
            </div>

            <div>
                <span>Cashier</span>

                <strong>
                    {{ $sale->user?->full_name
                        ?? $sale->user?->username
                        ?? 'Former user' }}
                </strong>
            </div>

            <div>
                <span>Customer</span>

                <strong>
                    {{ $sale->customer?->full_name
                        ?? 'Walk-in Customer' }}
                </strong>
            </div>

            <div>
                <span>Status</span>

                <strong>{{ ucfirst($sale->status) }}</strong>
            </div>
        </div>

        <div class="table-wrapper receipt-table-wrapper">
            <table class="receipt-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($sale->items as $saleItem)
                        <tr>
                            <td>
                                <strong>{{ $saleItem->item_name }}</strong>
                                <small>{{ $saleItem->sku }}</small>
                            </td>

                            <td>
                                ₱{{ number_format(
                                    $saleItem->unit_price,
                                    2
                                ) }}
                            </td>

                            <td>{{ $saleItem->quantity }}</td>

                            <td>
                                ₱{{ number_format(
                                    $saleItem->line_total,
                                    2
                                ) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="receipt-totals">
            <div>
                <span>Subtotal</span>

                <strong>
                    ₱{{ number_format($sale->subtotal, 2) }}
                </strong>
            </div>

            <div>
                <span>Cash Received</span>

                <strong>
                    ₱{{ number_format($sale->amount_paid, 2) }}
                </strong>
            </div>

            <div class="receipt-change">
                <span>Change</span>

                <strong>
                    ₱{{ number_format($sale->change_due, 2) }}
                </strong>
            </div>
        </div>

        <footer class="receipt-footer">
            <p>Thank you for your purchase!</p>
            <p>Please keep this receipt for your records.</p>
        </footer>
    </section>

    <div class="receipt-actions no-print">
        <a href="{{ route('pos.create') }}" class="button">
            New Sale
        </a>

        <button
            type="button"
            class="button secondary"
            onclick="window.print()"
        >
            Print Receipt
        </button>

        <a href="{{ route('items.index') }}" class="button secondary">
            View Inventory
        </a>
    </div>
@endsection