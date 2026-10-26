@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="hero">
        <p class="eyebrow">Point of Sale</p>

        <h1>Manage your accounts with ease.</h1>

        <p class="description">
            A simple Laravel POS application for managing customer and
            user account information.
        </p>

        <div class="hero-actions">
            <a href="{{ route('customers.index') }}" class="button">
                View Customers
            </a>

            <a href="{{ route('users.index') }}" class="button secondary">
                View Users
            </a>
        </div>
    </section>
@endsection