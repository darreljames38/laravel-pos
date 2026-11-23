<x-mail::message>
# Task Completed

The following task has been marked as completed:

<x-mail::panel>
**Task:** {{ $task->title }}

**Status:** {{ ucfirst($task->status) }}

**Task Date:** {{ $task->task_date->format('F j, Y') }}
</x-mail::panel>

This notification was generated because the task status changed from
**Pending** to **Done**.

<x-mail::button :url="route('tasks.index')">
View Task List
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>