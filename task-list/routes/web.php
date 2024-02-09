<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// class Task
// {
//     public function __construct(
//         public int $id,
//         public string $title,
//         public string $description,
//         public ?string $long_description,
//         public bool $completed,
//         public string $created_at,
//         public string $updated_at
//     ) {
//     }
// }

// $tasks = [
//     new Task(
//         1,
//         'Buy groceries',
//         'Task 1 description',
//         'Task 1 long description',
//         false,
//         '2023-03-01 12:00:00',
//         '2023-03-01 12:00:00'
//     ),
//     new Task(
//         2,
//         'Sell old stuff',
//         'Task 2 description',
//         null,
//         false,
//         '2023-03-02 12:00:00',
//         '2023-03-02 12:00:00'
//     ),
//     new Task(
//         3,
//         'Learn programming',
//         'Task 3 description',
//         'Task 3 long description',
//         true,
//         '2023-03-03 12:00:00',
//         '2023-03-03 12:00:00'
//     ),
//     new Task(
//         4,
//         'Take dogs for a walk',
//         'Task 4 description',
//         null,
//         false,
//         '2023-03-04 12:00:00',
//         '2023-03-04 12:00:00'
//     ),
// ];

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::get('/tasks', function () {
    return view('index', [
        // 'tasks' => App\Models\Task::all() //fetch all the records
        // 'tasks' => Task::latest()->get() //fetch all the latest data
        'tasks' => Task::latest()->paginate() //perform pagination
        // 'tasks' => App\Models\Task::latest()->where('completed', true)->get() //fetch all the latest data and status is completed

    ]);
})->name('tasks.index');

Route::view('/tasks/create', 'create')->name('tasks.create');


Route::get('/tasks/{task}/edit', function (Task $task) {
    // Route::get('/tasks/{id}/edit', function ($id) {
    // $task = collect($tasks)->firstWhere('id', $id);
    return view('edit', [
        // 'task' => Task::findOrFail($id) //this will find record with id if not then 404 page will render
        'task' => $task //Instead of id we will pass task in url
    ]);
})->name('tasks.edit');

// similarly we will edit all rotes like above which needed

Route::get('/tasks/{task}', function (Task $task) {
    // $task = collect($tasks)->firstWhere('id', $id);
    return view('show', [
        // 'task' => Task::findOrFail($id) //this will find record with id if not then 404 page will render
        'task' => $task //work above similar
    ]);
})->name('tasks.show');


Route::post('/tasks', function (TaskRequest $request) {

    // $data = $request->validate([
    //     'title' => 'required|max:255',
    //     'description' => 'required',
    //     'long_description' => 'required'
    // ]);

    $data = $request->validated();

    // $task = new Task;

    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];

    // $task->save();

    $task = Task::create($data);

    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task was successfully created!');
})->name('tasks.store');

Route::put('/tasks/{task}/edit', function (Task $task, TaskRequest $request) {

    //validate this in TaskRequest intead of here to create request use *** PHP Artisan make:request {request name} ***
    // $data = $request->validate([
    //     'title' => 'required|max:255',
    //     'description' => 'required',
    //     'long_description' => 'required'
    // ]);

    // $data = $request->validated();

    // $task= Task::findOrFail($id);

    // $task->title = $data['title'];
    // $task->description = $data['description'];
    // $task->long_description = $data['long_description'];

    // $task->save();

    $task->update($request->validated());


    return redirect()->route('tasks.show', ['task' => $task->id])->with('success', 'Task was successfully Updated!');
})->name('tasks.update');

Route::delete('/tasks/{task}', function (Task $task) {
    $task->delete();

    return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
})->name('tasks.destroy');


Route::put('/tasks/{task}/toggle-complete',function(Task $task){
    $task->toggleComplete();

    return redirect()->back()->with('sucess','task updated successfully!');
})->name('tasks.toggle-complete');


Route::fallback(function () {
    return 'Page does not exists';
});


// Route::get('/practice', function () use ($tasks) {
//     // return 'Hello Vishal This is first laravel project';
//     // return view('welcome');
//     return view('practice', [
//         'name' => 'vishal',
//         'tasks' => $tasks
//     ]);
// });

// Route::get('/hello', function () {
//     return 'hello';
// })->name('helloN');

// Route::get('/hallo', function () {
//     return redirect()->route('helloN');
// });

// Route::get('/greet/{name}', function ($name) {
//     return 'hello ' . $name;
// });
