@extends('layouts.app')

@section('title', 'Task List')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">Task Management</p>
            <h1>All Tasks</h1>

            <p class="description">
                View every task ordered by its scheduled date.
            </p>
        </div>
    </section>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Task Date</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->title }}</td>
                        <td>
                            <span class="status status-{{ $task->status }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </td>
                        <td>{{ $task->task_date->format('F d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No tasks were found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection