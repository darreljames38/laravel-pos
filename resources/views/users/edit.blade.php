@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">POS Accounts</p>
            <h1>Edit User</h1>

            <p class="description">
                Update user information and profile picture.
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
        action="{{ route('users.update', $user) }}"
        method="POST"
        enctype="multipart/form-data"
        class="account-form"
    >
        @csrf
        @method('PUT')

        <div class="avatar-preview">
            <img
                src="{{ $user->avatar
                    ? asset('storage/' . $user->avatar)
                    : asset('images/avatar-placeholder.svg') }}"
                alt="{{ $user->full_name }}"
                class="user-avatar large"
            >
        </div>

        <div class="form-group">
            <label for="username">Username</label>

            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username', $user->username) }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="full_name">Full Name</label>

            <input
                type="text"
                id="full_name"
                name="full_name"
                value="{{ old('full_name', $user->full_name) }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="avatar">Profile Picture</label>

            <input
                type="file"
                id="avatar"
                name="avatar"
                accept="image/*"
            >

            <small>
                Maximum file size: 2MB. The uploaded image will be
                prepared as a 300 × 300 thumbnail.
            </small>
        </div>

        <div class="form-actions">
            <button type="submit" class="button">
                Update User
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