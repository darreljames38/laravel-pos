@extends('layouts.app')

@section('title', 'Create Customer')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">POS Accounts</p>
            <h1>Create Customer</h1>

            <p class="description">
                Add a new customer account.
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
        action="{{ route('customers.store') }}"
        method="POST"
        class="account-form"
    >
        @csrf

        <div class="form-group">
            <label for="full_name">Full Name</label>

            <input
                type="text"
                id="full_name"
                name="full_name"
                value="{{ old('full_name') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="email">Email</label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>

            <input
                type="text"
                id="phone"
                name="phone"
                value="{{ old('phone') }}"
            >
        </div>

        <div class="form-actions">
            <button type="submit" class="button">
                Save Customer
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