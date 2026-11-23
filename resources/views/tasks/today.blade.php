@extends('layouts.app')

@section('title', "Today's Tasks")

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">Tasks for Today</p>
            <h1>Today's Tasks</h1>

            <p class="description">
                View all non-archived tasks scheduled for today.
            </p>
        </div>

        @auth
            <a href="{{ route('tasks.create') }}" class="button">
                Create Task
            </a>
        @endauth
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
                    <th>Title</th>
                    <th>Status</th>
                    <th>Task Date</th>

                    @auth
                        <th>Actions</th>
                    @endauth
                </tr>
            </thead>

            <tbody>
                @forelse ($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>

                        <td>
                            <span class="status {{ $task->status }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </td>

                        <td>{{ $task->task_date->format('F j, Y') }}</td>

                        @auth
                            <td>
                                <div class="table-actions">
                                    <a
                                        href="{{ route('tasks.edit', $task) }}"
                                        class="button small secondary"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('tasks.destroy', $task) }}"
                                        onsubmit="return confirm('Archive this task?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="button small danger"
                                        >
                                            Archive
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endauth
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->check() ? 4 : 3 }}">
                            No tasks are scheduled for today.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <p>
        <a href="{{ route('tasks.index') }}" class="button secondary">
            View All Tasks
        </a>
    </p>
@endsection