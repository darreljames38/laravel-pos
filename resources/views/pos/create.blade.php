@extends('layouts.app')

@section('title', 'Cashier')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">Point of Sale</p>
            <h1>Cashier</h1>

            <p class="description">
                Select products, enter payment, and complete the sale.
            </p>
        </div>

        <a href="{{ route('items.index') }}" class="button secondary">
            Manage Items
        </a>
    </section>

    @if ($errors->any())
        <div class="alert error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="pos-layout">
        {{-- Product selection --}}
        <section class="card pos-products">
            <div class="pos-section-heading">
                <div>
                    <h2>Products</h2>
                    <p>Select an available item to add it to the cart.</p>
                </div>

                <input
                    id="product-search"
                    type="search"
                    placeholder="Search name, SKU, or category"
                    autocomplete="off"
                >
            </div>

            <div id="product-grid" class="product-grid">
                @forelse ($items as $item)
                    <button
                        type="button"
                        class="product-card"
                        data-product-id="{{ $item->id }}"
                        data-product-name="{{ $item->name }}"
                        data-product-sku="{{ $item->sku }}"
                        data-product-category="{{ $item->category }}"
                        data-product-price="{{ $item->selling_price }}"
                        data-product-stock="{{ $item->stock_quantity }}"
                    >
                        <span class="product-category">
                            {{ $item->category }}
                        </span>

                        <strong>{{ $item->name }}</strong>

                        <span class="product-sku">
                            SKU: {{ $item->sku }}
                        </span>

                        <span class="product-price">
                            ₱{{ number_format($item->selling_price, 2) }}
                        </span>

                        <span class="product-stock">
                            {{ $item->stock_quantity }} in stock
                        </span>
                    </button>
                @empty
                    <div class="empty-state">
                        <h3>No products available</h3>

                        <p>
                            Create an active item with available stock before
                            using the cashier.
                        </p>

                        <a
                            href="{{ route('items.create') }}"
                            class="button"
                        >
                            Create Item
                        </a>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Shopping cart and checkout --}}
        <section class="card pos-cart-panel">
            <form
                id="checkout-form"
                method="POST"
                action="{{ route('pos.checkout') }}"
            >
                @csrf

                <div class="pos-section-heading">
                    <div>
                        <h2>Current Sale</h2>

                        <p>
                            Cashier:
                            <strong>
                                {{ auth()->user()->full_name
                                    ?? auth()->user()->username }}
                            </strong>
                        </p>
                    </div>

                    <button
                        id="clear-cart"
                        type="button"
                        class="button small danger"
                    >
                        Clear
                    </button>
                </div>

                <div class="form-group">
                    <label for="customer_id">Customer</label>

                    <select id="customer_id" name="customer_id">
                        <option value="">Walk-in Customer</option>

                        @foreach ($customers as $customer)
                            <option
                                value="{{ $customer->id }}"
                                @selected(
                                    old('customer_id') == $customer->id
                                )
                            >
                                {{ $customer->full_name }}
                            </option>
                        @endforeach
                    </select>

                    @error('customer_id')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="cart-table-wrapper">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty.</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody id="cart-body">
                            {{-- JavaScript inserts cart rows here. --}}
                        </tbody>
                    </table>

                    <div id="empty-cart" class="empty-cart">
                        The cart is empty.
                    </div>
                </div>

                <div id="cart-inputs">
                    {{-- JavaScript inserts hidden item inputs here. --}}
                </div>

                <div class="checkout-summary">
                    <div>
                        <span>Subtotal</span>
                        <strong id="subtotal-display">₱0.00</strong>
                    </div>

                    <div class="form-group payment-group">
                        <label for="amount_paid">Cash Received</label>

                        <input
                            id="amount_paid"
                            type="number"
                            name="amount_paid"
                            value="{{ old('amount_paid') }}"
                            min="0"
                            step="0.01"
                            placeholder="0.00"
                            required
                        >

                        @error('amount_paid')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="change-row">
                        <span>Change</span>
                        <strong id="change-display">₱0.00</strong>
                    </div>
                </div>

                <button
                    id="checkout-button"
                    type="submit"
                    class="button checkout-button"
                    disabled
                >
                    Complete Sale
                </button>
            </form>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cart = new Map();

            const productCards = Array.from(
                document.querySelectorAll('.product-card')
            );

            const productMap = new Map();

            const cartBody = document.getElementById('cart-body');
            const cartInputs = document.getElementById('cart-inputs');
            const emptyCart = document.getElementById('empty-cart');
            const subtotalDisplay =
                document.getElementById('subtotal-display');
            const amountPaidInput =
                document.getElementById('amount_paid');
            const changeDisplay =
                document.getElementById('change-display');
            const checkoutButton =
                document.getElementById('checkout-button');
            const checkoutForm =
                document.getElementById('checkout-form');
            const clearButton =
                document.getElementById('clear-cart');
            const searchInput =
                document.getElementById('product-search');

            const money = new Intl.NumberFormat('en-PH', {
                style: 'currency',
                currency: 'PHP',
            });

            productCards.forEach((card) => {
                const product = {
                    id: Number(card.dataset.productId),
                    name: card.dataset.productName,
                    sku: card.dataset.productSku,
                    category: card.dataset.productCategory,
                    price: Number(card.dataset.productPrice),
                    stock: Number(card.dataset.productStock),
                };

                productMap.set(product.id, product);

                card.addEventListener('click', () => {
                    addToCart(product);
                });
            });

            function addToCart(product) {
                const existing = cart.get(product.id);
                const currentQuantity = existing?.quantity ?? 0;

                if (currentQuantity >= product.stock) {
                    window.alert(
                        `${product.name} only has ${product.stock} unit(s).`
                    );

                    return;
                }

                cart.set(product.id, {
                    ...product,
                    quantity: currentQuantity + 1,
                });

                renderCart();
            }

            function updateQuantity(productId, quantity) {
                const cartItem = cart.get(productId);

                if (! cartItem) {
                    return;
                }

                if (quantity <= 0) {
                    cart.delete(productId);
                    renderCart();

                    return;
                }

                if (quantity > cartItem.stock) {
                    window.alert(
                        `${cartItem.name} only has `
                        + `${cartItem.stock} unit(s).`
                    );

                    renderCart();

                    return;
                }

                cartItem.quantity = quantity;
                cart.set(productId, cartItem);

                renderCart();
            }

            function removeFromCart(productId) {
                cart.delete(productId);
                renderCart();
            }

            function getSubtotal() {
                return Array.from(cart.values()).reduce(
                    (total, cartItem) => {
                        return total
                            + cartItem.price * cartItem.quantity;
                    },
                    0
                );
            }

            function updatePaymentSummary() {
                const subtotal = getSubtotal();
                const amountPaid = Number(amountPaidInput.value || 0);
                const change = Math.max(amountPaid - subtotal, 0);

                subtotalDisplay.textContent = money.format(subtotal);
                changeDisplay.textContent = money.format(change);

                checkoutButton.disabled =
                    cart.size === 0
                    || amountPaid < subtotal;
            }

            function renderCart() {
                cartBody.innerHTML = '';
                cartInputs.innerHTML = '';

                const cartItems = Array.from(cart.values());

                emptyCart.hidden = cartItems.length > 0;

                cartItems.forEach((cartItem, index) => {
                    const lineTotal =
                        cartItem.price * cartItem.quantity;

                    const row = document.createElement('tr');

                    row.innerHTML = `
                        <td>
                            <strong>${escapeHtml(cartItem.name)}</strong>
                            <small>
                                ${escapeHtml(cartItem.sku)}
                                · ${money.format(cartItem.price)}
                            </small>
                        </td>

                        <td>
                            <div class="quantity-control">
                                <button
                                    type="button"
                                    class="quantity-button decrease"
                                    aria-label="Decrease quantity"
                                >
                                    −
                                </button>

                                <input
                                    type="number"
                                    class="quantity-input"
                                    value="${cartItem.quantity}"
                                    min="1"
                                    max="${cartItem.stock}"
                                    aria-label="Quantity"
                                >

                                <button
                                    type="button"
                                    class="quantity-button increase"
                                    aria-label="Increase quantity"
                                >
                                    +
                                </button>
                            </div>
                        </td>

                        <td>
                            <strong>${money.format(lineTotal)}</strong>
                        </td>

                        <td>
                            <button
                                type="button"
                                class="remove-cart-item"
                                aria-label="Remove item"
                            >
                                ×
                            </button>
                        </td>
                    `;

                    row.querySelector('.decrease')
                        .addEventListener('click', () => {
                            updateQuantity(
                                cartItem.id,
                                cartItem.quantity - 1
                            );
                        });

                    row.querySelector('.increase')
                        .addEventListener('click', () => {
                            updateQuantity(
                                cartItem.id,
                                cartItem.quantity + 1
                            );
                        });

                    row.querySelector('.quantity-input')
                        .addEventListener('change', (event) => {
                            updateQuantity(
                                cartItem.id,
                                Number(event.target.value)
                            );
                        });

                    row.querySelector('.remove-cart-item')
                        .addEventListener('click', () => {
                            removeFromCart(cartItem.id);
                        });

                    cartBody.appendChild(row);

                    const itemIdInput =
                        document.createElement('input');

                    itemIdInput.type = 'hidden';
                    itemIdInput.name = `items[${index}][id]`;
                    itemIdInput.value = cartItem.id;

                    const quantityInput =
                        document.createElement('input');

                    quantityInput.type = 'hidden';
                    quantityInput.name =
                        `items[${index}][quantity]`;
                    quantityInput.value = cartItem.quantity;

                    cartInputs.append(itemIdInput, quantityInput);
                });

                updatePaymentSummary();
            }

            function escapeHtml(value) {
                const element = document.createElement('div');
                element.textContent = value;

                return element.innerHTML;
            }

            amountPaidInput.addEventListener(
                'input',
                updatePaymentSummary
            );

            clearButton.addEventListener('click', () => {
                if (
                    cart.size > 0
                    && ! window.confirm('Clear all items from the cart?')
                ) {
                    return;
                }

                cart.clear();
                renderCart();
            });

            searchInput?.addEventListener('input', () => {
                const search = searchInput.value
                    .trim()
                    .toLowerCase();

                productCards.forEach((card) => {
                    const searchableText = [
                        card.dataset.productName,
                        card.dataset.productSku,
                        card.dataset.productCategory,
                    ].join(' ').toLowerCase();

                    card.hidden = ! searchableText.includes(search);
                });
            });

            checkoutForm.addEventListener('submit', (event) => {
                const subtotal = getSubtotal();
                const amountPaid = Number(amountPaidInput.value || 0);

                if (cart.size === 0) {
                    event.preventDefault();
                    window.alert('Add at least one item to the cart.');

                    return;
                }

                if (amountPaid < subtotal) {
                    event.preventDefault();
                    window.alert(
                        'The cash received is less than the total.'
                    );

                    return;
                }

                checkoutButton.disabled = true;
                checkoutButton.textContent = 'Processing Sale...';
            });

            const oldItems = @json(old('items', []));

            oldItems.forEach((oldItem) => {
                const product = productMap.get(Number(oldItem.id));

                if (! product) {
                    return;
                }

                const quantity = Math.min(
                    Math.max(Number(oldItem.quantity) || 1, 1),
                    product.stock
                );

                cart.set(product.id, {
                    ...product,
                    quantity,
                });
            });

            renderCart();
        });
    </script>
@endsection