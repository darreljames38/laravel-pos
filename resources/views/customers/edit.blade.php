@extends('layouts.app')

@section('title', 'Edit Customer')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">POS Accounts</p>
            <h1>Edit Customer</h1>

            <p class="description">
                Update this customer's information.
            </p>
        </div>
    </section>

    @if ($errors->any())
        <div class="alert error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form
        action="{{ route('customers.update', $customer) }}"
        method="POST"
        class="account-form"
    >
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="full_name">Full Name</label>

            <input
                type="text"
                id="full_name"
                name="full_name"
                value="{{ old('full_name', $customer->full_name) }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="email">Email</label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $customer->email) }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>

            <input
                type="text"
                id="phone"
                name="phone"
                value="{{ old('phone', $customer->phone) }}"
            >
        </div>

        <div class="form-actions">
            <button type="submit" class="button">
                Update Customer
            </button>

            <a
                href="{{ route('customers.index') }}"
                class="button secondary"
            >
                Cancel
            </a>
        </div>
    </form>
@endsection