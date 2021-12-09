<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  <title>Sample Laravel Basic Task List</title>
  <link rel="stylesheet" type="text/css" href={{ URL::asset('semantic/semantic.min.css') }}>

  {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/semantic-ui/2.2.10/semantic.min.css"> --}}
  <style type="text/css">
    .main.container {
      padding-top: 6em;
      padding-bottom: 2em;
    }
    .task-done {
      text-decoration: line-through;
    }
    table td form {
      display: inline;
    }
    @media only screen and (max-width: 767px)
      .ui.table:not(.unstackable) tbody, .ui.table:not(.unstackable) tr, .ui.table:not(.unstackable) tr>td, .ui.table:not(.unstackable) tr>th {
          width: auto!important;
          display: inline-table!important;
      }
  </style>
</head>
<body>

  <div class="ui fixed inverted menu">
    <div class="ui text container">
      <a href="/" class="header item">
        <i class="inverted large tasks icon"></i>
        Basic Task List
      </a>
    </div>
  </div>

  <div class="ui main text container">
    <div class="ui center aligned basic segment">
      <!-- Add task form -->
      <form class="ui form {{ count($errors)?'error':'' }}" method="POST" action="{{ url('tasks') }}">

        {{ csrf_field() }}

        <div class="ui fluid action input">
          <input placeholder="Enter task name" type="text" name="name">
          <button type="submit" class="ui primary button">Add Task</button>
        </div>

        <!-- Display Validation Errors -->
        @include('layouts.errors')

      </form>
      <div class="ui horizontal divider">
        Or
      </div>
      <!-- Search task form -->
      <form action="{{ url('tasks/search') }}" method="POST" role="search">
          {{ csrf_field() }}

          <div class="ui category search">
            <div class="ui icon input">
              <input class="prompt" type="text" name="q" placeholder="Search tasks...">
              <button type="submit" class="btn btn-default">
                  <i class="search icon"></i>
              </button>

            </div>
            <div class="results"></div>
          </div>
      </form>
    </div>
    @if(session()->has('error'))
        <div class="ui negative message">
          <i class="close icon"></i>
          <div class="header">
            {{ session()->get('error') }}
          </div>
        </div>
    @endif
    <!-- Current Tasks -->
      <table class="ui celled structured table">
      	<thead>
      		<tr>
            <th>Tasks</th>
			      <th class="right aligned">
              <form action="{{ route('task.destroy', [ 'task'=> 0 ]) }}" method="POST">
                {{ csrf_field() }}
                @method("DELETE")
                <button type="submit" class="ui negative button" style="width:8em;">
                  Delete All
                </button>
              </form>
            </th>
      		</tr>
      	</thead>

      	<tbody>
      		@foreach(isset($details) ? $details : $tasks as $task)
      			<tr>
      				<td >
                <div class="ui input">
                  <input onchange="myChangeFunction(this)" class="{{ $task->done?'disabled task-done':''}}" {{ $task->done?'disabled':''}} type="text" name="n{{ $task->id }}" id="{{ $task->id }}" value="{{ $task->name }}">
                </div>

      				</td>
              <td class="right aligned">

                <form action="/tasks/{{ $task->id }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}
                  <input hidden type="text" name="{{ $task->id }}" id="i{{ $task->id }}">
                  <button type="submit" class="ui positive icon button" {{ $task->done?'disabled':''}}>
                    <i class="edit icon"></i>
                  </button>
                </form>
                <form action="/tasks/{{ $task->id }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('PATCH') }}
                  <button type="submit" class="ui {{ $task->done?'negative':'positive' }} icon button">
                    <i class="{{ $task->done?'minus':'check' }} icon"></i>
                  </button>
                </form>
                <form action="{{ route('task.destroy', [ 'task'=> $task->id ]) }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <button type="submit" class="ui negative icon button">
                    <i class="trash icon"></i>
                  </button>
                </form>
              </td>
      			</tr>

      		@endforeach
      	</tbody>
      </table>
      {{ isset($details) ? $details : $tasks->links('layouts.pagination') }}



  </div>

  <script
    src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/semantic-ui/2.2.10/semantic.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function($)
  {
    $(document).on('click', '.row_data', function(event)
    {
      event.preventDefault();

      if($(this).attr('edit_type') == 'button')
      {
        return false;
      }

      //make div editable
      $(this).closest('div').attr('contenteditable', 'true');
      //add bg css
      $(this).addClass('bg-warning').css('padding','5px');

      $(this).focus();
    })
  });
  </script>
  <script type="text/javascript">
  function myChangeFunction(input1){
    document.getElementById("i"+input1.id).value = input1.value;
    console.log(input1.id);
  }
  </script>
</body>

</html>
