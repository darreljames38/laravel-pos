@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">Task Management</p>
            <h1>Edit Task</h1>

            <p class="description">
                Update the task details or mark it as completed.
            </p>
        </div>
    </section>

    <section class="card form-card">
        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('tasks.update', $task) }}"
        >
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Task Title</label>

                <input
                    id="title"
                    type="text"
                    name="title"
                    value="{{ old('title', $task->title) }}"
                    maxlength="150"
                    required
                    autofocus
                >

                @error('title')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status</label>

                <select id="status" name="status" required>
                    <option
                        value="pending"
                        @selected(
                            old('status', $task->status) === 'pending'
                        )
                    >
                        Pending
                    </option>

                    <option
                        value="done"
                        @selected(
                            old('status', $task->status) === 'done'
                        )
                    >
                        Done
                    </option>
                </select>

                @error('status')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="task_date">Task Date</label>

                <input
                    id="task_date"
                    type="date"
                    name="task_date"
                    value="{{ old(
                        'task_date',
                        $task->task_date->format('Y-m-d')
                    ) }}"
                    required
                >

                @error('task_date')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="button">
                    Update Task
                </button>

                <a
                    href="{{ route('tasks.index') }}"
                    class="button secondary"
                >
                    Cancel
                </a>
            </div>
        </form>
    </section>
@endsection