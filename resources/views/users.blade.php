@extends('layouts.app')

@section('title', 'User Accounts')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">Accounts</p>
            <h1>User Accounts</h1>

            <p class="description">
                View all system users stored in the database.
            </p>
        </div>
    </section>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Full Name</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->full_name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            No user records were found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection