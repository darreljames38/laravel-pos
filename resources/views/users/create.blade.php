@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">POS Accounts</p>
            <h1>Create User</h1>

            <p class="description">
                Add a new POS user account.
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
        action="{{ route('users.store') }}"
        method="POST"
        class="account-form"
    >
        @csrf

        <div class="form-group">
            <label for="username">Username</label>

            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username') }}"
                required
            >
        </div>

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

        <div class="form-actions">
            <button type="submit" class="button">
                Save User
            </button>

            <a
                href="{{ route('users.index') }}"
                class="button secondary"
            >
                Cancel
            </a>
        </div>
    </form>
@endsection