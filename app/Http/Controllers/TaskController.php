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
    $tasks = Task::orderBy( 'done', 'asc','created_at', 'asc')->paginate(5);

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

  /**
   * Update the specified task in storage. For this case, just toggle task's done status.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Task  $task
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Task $task)
  {
      $task->done = !$task->done;
      $task->save();

      return back();
  }
  public function updateName(Request $request, Task $task)
  {
    $taskID = $task->id;
    $taskName = $request->input($taskID);
    Task::where('id',$taskID)->update(['name'=>$taskName]);

    return back();
  }
  public function search(Request $request, Task $task)
  {
    $q = $request->input('q');
    $tasks = Task::where('name','LIKE','%'.$q.'%')->paginate(5);
    // return view('tasks.index', compact('tasks'));
    if (count ( $tasks ) > 0)
        return view('tasks.index', compact('tasks'));
    else
        return redirect('/')->with('error', 'No Records!');
  }
}
