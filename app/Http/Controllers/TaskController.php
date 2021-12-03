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

    return view('welcome');

  }
}
