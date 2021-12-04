<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;


class TaskController extends Controller
{
  /**
   * Display a listing of tasks with form for adding new task.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $tasks = Task::orderBy('created_at', 'asc')->paginate(5);

    return view('tasks.index', compact('tasks'));

  }
    /**
   * Store a newly created task in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validate($request, [
    'name' => 'required|max:255'
  ]);

  $task = new Task;
  $task->name = $request->name;
  $task->save();

  return redirect('/');
  }

    /**
   * Remove the specified task from storage.
   *
   * @param  \App\Task  $task
   * @return \Illuminate\Http\Response
   */
  public function destroy(Task $task)
  {
    $task->delete();

    return redirect('/');
  }
}
