<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(): View
    {
        $items = Item::query()
            ->orderBy('name')
            ->get();

        return view('items.index', compact('items'));
    }

    public function create(): View
    {
        return view('items.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],
            'sku' => [
                'required',
                'string',
                'max:50',
                'unique:items,sku',
            ],
            'category' => [
                'required',
                'string',
                'max:100',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'selling_price' => [
                'required',
                'numeric',
                'min:0',
                'decimal:0,2',
            ],
            'stock_quantity' => [
                'required',
                'integer',
                'min:0',
            ],
            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

        Item::create($validated);

        return redirect()
            ->route('items.index')
            ->with('success', 'Item created successfully.');
    }

    public function show(Item $item): View
    {
        return view('items.show', compact('item'));
    }

    public function edit(Item $item): View
    {
        return view('items.edit', compact('item'));
    }

    public function update(
        Request $request,
        Item $item
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],
            'sku' => [
                'required',
                'string',
                'max:50',
                Rule::unique('items', 'sku')->ignore($item->id),
            ],
            'category' => [
                'required',
                'string',
                'max:100',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'selling_price' => [
                'required',
                'numeric',
                'min:0',
                'decimal:0,2',
            ],
            'stock_quantity' => [
                'required',
                'integer',
                'min:0',
            ],
            'status' => [
                'required',
                'in:active,inactive',
            ],
        ]);

        $item->update($validated);

        return redirect()
            ->route('items.index')
            ->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item): RedirectResponse
    {
        $item->delete();

        return redirect()
            ->route('items.index')
            ->with('success', 'Item deleted successfully.');
    }
}