@extends('layouts.app')

@section('title', 'Task List')

@section('content')
<nav class="mb-4">
    <a class="font-medium text-gray-700"
        href="{{ route('tasks.create') }}">Add Task</a>
</nav>
@forelse($tasks as $task)
    <div @class(['bg-gray-100' => $loop->index%2 == 1])>
        <a href="{{ route('tasks.show',['task' => $task->id]) }}"
            @class(['line-through' => $task->completed])>
            {{ $task->title }}
        </a>
    </div>


@empty
    <div>There is no tasks</div>
@endforelse

@if($task->count())
    <nav class="mt-4">
        {{ $tasks->links() }}
    </nav>
@endif

@endsection
