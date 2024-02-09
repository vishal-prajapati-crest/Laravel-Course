@extends('layouts.app')

@section('title', $task->title)

@section('content')
<div class="mb-4">
    <a class="font-medium text-gray-700 hover:text-gray-800" href="{{ route('tasks.index') }}"> ← Go
        Back</a>
</div>
<p class="mb-4 text-slate-700">{{ $task->description }}</p>

@if($task->long_description)
    <p class="mb-4 text-slate-700">{{ $task->long_description }}</p>
@endif

<p class="mb-4 text-sm text-slate-500">Created {{ $task->created_at->diffForHumans() }} • Updated
    {{ $task->updated_at->diffForHumans() }}</p>

<p class="mb-4">
    @if($task->completed)
        <span class="font-medium text-green-500"> Completed </span>
    @else
        <span class="font-medium text-red-500"> Not Completed </span>
    @endif
</p>

<div class="flex justify-between">

    <div class="flex gap-1 align-center">
        <div
            class="rounded-md px-3 py-1 text-center font-medium shadow-sm  ring-1 ring-blue-600/10 bg-blue-500 text-neutral-50 hover:bg-blue-400 hover:ring-blue-500/10">
            <a
                href="{{ route('tasks.edit', ['task' => $task->id]) }}">✏
                Edit</a>
        </div>
        <div
            class="rounded-md px-3 py-0.5 text-center font-medium shadow-sm  ring-1 ring-red-600/10 bg-red-500 text-neutral-50 hover:bg-red-400 hover:ring-red-500/10">
            <form method="POST"
                action="{{ route('tasks.destroy',['task' => $task->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit">🗑 Delete</button>
            </form>
        </div>
    </div>

    <div
        class="rounded-md px-3 py-0.5 text-center font-medium shadow-sm  ring-1 ring-green-600/10 bg-green-500 text-neutral-50 hover:bg-green-400 hover:ring-green-500/10">
        <form method="POST"
            action="{{ route('tasks.toggle-complete',['task' => $task]) }}">
            @csrf
            @method('PUT')
            <button type="submit">Mark as
                {{ $task->completed ? 'not completed' : 'completed' }}</button>

        </form>
    </div>




</div>
@endsection
