<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PosController extends Controller
{
    public function create(): View
    {
        $items = Item::query()
            ->where('status', 'active')
            ->where('stock_quantity', '>', 0)
            ->orderBy('name')
            ->get();

        $customers = Customer::query()
            ->orderBy('full_name')
            ->get();

        return view(
            'pos.create',
            compact('items', 'customers')
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => [
                'nullable',
                'exists:customers,id',
            ],
            'amount_paid' => [
                'required',
                'numeric',
                'min:0',
            ],
            'items' => [
                'required',
                'array',
                'min:1',
            ],
            'items.*.id' => [
                'required',
                'integer',
                'exists:items,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $sale = DB::transaction(function () use (
            $validated,
            $request
        ): Sale {
            $requestedQuantities = [];

            foreach ($validated['items'] as $cartItem) {
                $itemId = (int) $cartItem['id'];
                $quantity = (int) $cartItem['quantity'];

                $requestedQuantities[$itemId] =
                    ($requestedQuantities[$itemId] ?? 0) + $quantity;
            }

            $items = Item::query()
                ->whereIn('id', array_keys($requestedQuantities))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $subtotal = 0;
            $preparedItems = [];

            foreach ($requestedQuantities as $itemId => $quantity) {
                $item = $items->get($itemId);

                if (! $item || $item->status !== 'active') {
                    throw ValidationException::withMessages([
                        'items' => 'One of the selected items is unavailable.',
                    ]);
                }

                if ($quantity > $item->stock_quantity) {
                    throw ValidationException::withMessages([
                        'items' => "{$item->name} only has "
                            .$item->stock_quantity
                            .' unit(s) available.',
                    ]);
                }

                $unitPrice = (float) $item->selling_price;
                $lineTotal = round($unitPrice * $quantity, 2);

                $subtotal = round($subtotal + $lineTotal, 2);

                $preparedItems[] = [
                    'item' => $item,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'line_total' => $lineTotal,
                ];
            }

            $amountPaid = round(
                (float) $validated['amount_paid'],
                2
            );

            if ($amountPaid < $subtotal) {
                throw ValidationException::withMessages([
                    'amount_paid' => 'Payment is less than the total amount.',
                ]);
            }

            $receiptNumber = $this->generateReceiptNumber();

            $sale = Sale::create([
                'receipt_number' => $receiptNumber,
                'user_id' => $request->user()->id,
                'customer_id' => $validated['customer_id'] ?? null,
                'subtotal' => $subtotal,
                'amount_paid' => $amountPaid,
                'change_due' => round($amountPaid - $subtotal, 2),
                'status' => 'completed',
                'sold_at' => now(),
            ]);

            foreach ($preparedItems as $preparedItem) {
                $item = $preparedItem['item'];

                $sale->items()->create([
                    'item_id' => $item->id,
                    'item_name' => $item->name,
                    'sku' => $item->sku,
                    'unit_price' => $preparedItem['unit_price'],
                    'quantity' => $preparedItem['quantity'],
                    'line_total' => $preparedItem['line_total'],
                ]);

                $item->decrement(
                    'stock_quantity',
                    $preparedItem['quantity']
                );
            }

            return $sale;
        });

        return redirect()
            ->route('sales.show', $sale)
            ->with('success', 'Sale completed successfully.');
    }

    public function show(Sale $sale): View
    {
        $sale->load([
            'items',
            'user',
            'customer',
        ]);

        return view('pos.receipt', compact('sale'));
    }

    private function generateReceiptNumber(): string
    {
        do {
            $receiptNumber = 'POS-'
                .now()->format('Ymd-His')
                .'-'
                .Str::upper(Str::random(4));
        } while (
            Sale::where('receipt_number', $receiptNumber)->exists()
        );

        return $receiptNumber;
    }
}