@extends('layouts.app')

@section('title', 'Customer Accounts')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">Accounts</p>
            <h1>Customer Accounts</h1>

            <p class="description">
                View all customers stored in the database.
            </p>
        </div>
    </section>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->full_name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone ?? 'Not provided' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            No customer records were found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection