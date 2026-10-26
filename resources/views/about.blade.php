@extends('layouts.app')

@section('title', 'About')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">About</p>
            <h1>About the POS System</h1>

            <p class="description">
                This Laravel POS application manages customer and user
                account information using a database, Eloquent models,
                controllers, routes, and Blade views.
            </p>
        </div>
    </section>

    <section class="card">
        <h2>Developer</h2>

        <p>
            This system was developed by Darrel James Sanchez as a Laravel
            learning project.
        </p>
    </section>
@endsection