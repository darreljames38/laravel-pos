@if ($errors->any())
    <div class="alert error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <label for="name">Item Name</label>

    <input
        id="name"
        type="text"
        name="name"
        value="{{ old('name', $item?->name) }}"
        maxlength="150"
        required
        autofocus
    >

    @error('name')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="sku">SKU</label>

    <input
        id="sku"
        type="text"
        name="sku"
        value="{{ old('sku', $item?->sku) }}"
        maxlength="50"
        required
    >

    @error('sku')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="category">Category</label>

    <input
        id="category"
        type="text"
        name="category"
        value="{{ old('category', $item?->category) }}"
        maxlength="100"
        placeholder="Example: Beverages"
        required
    >

    @error('category')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="description">Description</label>

    <textarea
        id="description"
        name="description"
        rows="4"
        maxlength="1000"
    >{{ old('description', $item?->description) }}</textarea>

    @error('description')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="selling_price">Selling Price</label>

    <input
        id="selling_price"
        type="number"
        name="selling_price"
        value="{{ old('selling_price', $item?->selling_price) }}"
        min="0"
        step="0.01"
        required
    >

    @error('selling_price')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="stock_quantity">Stock Quantity</label>

    <input
        id="stock_quantity"
        type="number"
        name="stock_quantity"
        value="{{ old('stock_quantity', $item?->stock_quantity ?? 0) }}"
        min="0"
        step="1"
        required
    >

    @error('stock_quantity')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="status">Status</label>

    <select id="status" name="status" required>
        <option
            value="active"
            @selected(old('status', $item?->status ?? 'active') === 'active')
        >
            Active
        </option>

        <option
            value="inactive"
            @selected(old('status', $item?->status) === 'inactive')
        >
            Inactive
        </option>
    </select>

    @error('status')
        <p class="field-error">{{ $message }}</p>
    @enderror
</div>