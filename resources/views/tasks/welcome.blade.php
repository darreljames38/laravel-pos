@extends('layouts.app')

@section('title', "Today's Tasks")

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">Tasks for Today</p>
            <h1>Welcome back.</h1>

            <p class="description">
                Here are your tasks for {{ now()->format('F d, Y') }}.
            </p>
        </div>
    </section>

    <div class="task-grid">
        @forelse ($tasks as $task)
            <article class="task-card">
                <span class="status status-{{ $task->status }}">
                    {{ ucfirst($task->status) }}
                </span>

                <h2>{{ $task->title }}</h2>
                <p>{{ $task->task_date->format('F d, Y') }}</p>
            </article>
        @empty
            <div class="card">
                <h2>No tasks today</h2>
                <p>You have no scheduled tasks for today.</p>
            </div>
        @endforelse
    </div>
@endsection