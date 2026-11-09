@extends('layouts.app')

@section('title', 'Customer Accounts')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">POS Accounts</p>
            <h1>Customer Accounts</h1>

            <p class="description">
                Manage customer information stored in the POS database.
            </p>
        </div>

        <a href="{{ route('customers.create') }}" class="button">
            New Customer
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
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->full_name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone ?? 'Not provided' }}</td>
                        <td>
                            <a
                                href="{{ route('customers.edit', $customer) }}"
                                class="button small secondary"
                            >
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            No customer records were found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection