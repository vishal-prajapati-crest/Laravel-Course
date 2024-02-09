<div>Hello this is blade template.</div>

@isset($name)
<div>Welcome {{$name}}</div>
<div> Current Time is {{time()}}</div>
@endisset



<h1>Task - List</h1>
@foreach($tasks as $task)

@php
$isPending = $task->completed;
@endphp

<h3 @style([ 'color: red'=> $isPending,
  'color: green'=> !$isPending
  ])>{{$task->id}}. {{$task->title}}</h3>

<span>{{$task->description}}</span>
<span> &nbsp; {{$task->long_description}}</span>
@endforeach