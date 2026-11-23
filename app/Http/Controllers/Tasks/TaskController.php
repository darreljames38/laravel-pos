<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Mail\TaskCompleted;
use App\Models\Tasks\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display all non-archived tasks.
     */
    public function index(): View
    {
        $tasks = Task::query()
            ->where('is_archived', false)
            ->orderBy('task_date')
            ->orderBy('id')
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Display today's non-archived tasks.
     */
    public function today(): View
    {
        $tasks = Task::query()
            ->whereDate('task_date', now()->toDateString())
            ->where('is_archived', false)
            ->orderBy('id')
            ->get();

        return view('tasks.today', compact('tasks'));
    }

    /**
     * Display the new-task form.
     */
    public function create(): View
    {
        return view('tasks.create');
    }

    /**
     * Save a newly created task.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:150',
            ],
            'status' => [
                'required',
                'in:pending,done',
            ],
            'task_date' => [
                'required',
                'date',
            ],
        ]);

        $validated['is_archived'] = false;

        Task::create($validated);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the task edit form.
     */
    public function edit(Task $task): View
    {
        abort_if(
            $task->is_archived,
            404,
            'Task not found.'
        );

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update an existing task.
     */
    public function update(
        Request $request,
        Task $task
    ): RedirectResponse {
        abort_if(
            $task->is_archived,
            404,
            'Task not found.'
        );

        $previousStatus = strtolower(
            trim((string) $task->status)
        );

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:150',
            ],
            'status' => [
                'required',
                'in:pending,done',
            ],
            'task_date' => [
                'required',
                'date',
            ],
        ]);

        $task->update($validated);
        $task->refresh();

        $currentStatus = strtolower(
            trim((string) $task->status)
        );

        $recipient = $request->user()?->email;

        if (
            $previousStatus !== 'done' &&
            $currentStatus === 'done' &&
            $recipient
        ) {
            Mail::to($recipient)
                ->send(new TaskCompleted($task));
        }

        return redirect()
            ->route('tasks.index')
            ->with(
                'success',
                $currentStatus === 'done' &&
                $previousStatus !== 'done'
                    ? 'Task completed and notification email generated.'
                    : 'Task updated successfully.'
            );
    }

    /**
     * Archive a task instead of permanently deleting it.
     */
    public function destroy(Task $task): RedirectResponse
    {
        abort_if(
            $task->is_archived,
            404,
            'Task not found.'
        );

        $task->update([
            'is_archived' => true,
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task archived successfully.');
    }
}