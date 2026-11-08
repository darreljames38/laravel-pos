@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">Account</p>
            <h1>Profile</h1>
        </div>
    </section>

    @if ($user)
        <section class="card profile-card">
            <div>
                <span class="profile-label">Username</span>
                <h2>{{ $user->username }}</h2>
            </div>

            <div>
                <span class="profile-label">Full Name</span>
                <p>{{ $user->full_name }}</p>
            </div>

            <div>
                <span class="profile-label">Email</span>
                <p>{{ $user->email }}</p>
            </div>
        </section>
    @else
        <section class="card">
            <p>No profile record was found.</p>
        </section>
    @endif
@endsection