@extends('layouts.app')

@section('title', 'User Accounts')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">POS Accounts</p>
            <h1>User Accounts</h1>

            <p class="description">
                Manage POS users and their profile pictures.
            </p>
        </div>

        <a href="{{ route('users.create') }}" class="button">
            New User
        </a>
    </section>

    @if (session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            <img
                                src="{{ $user->avatar
                                    ? asset('storage/' . $user->avatar)
                                    : asset('images/avatar-placeholder.svg') }}"
                                alt="{{ $user->full_name }}"
                                class="user-avatar"
                            >
                        </td>

                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->full_name }}</td>

                        <td>
                            <a
                                href="{{ route('users.edit', $user) }}"
                                class="button small secondary"
                            >
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            No user records were found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection