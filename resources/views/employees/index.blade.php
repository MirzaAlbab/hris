@extends('layouts.dashboard')

@section('content')
    <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Task</h3>
                <p class="text-subtitle text-muted">Employee Task</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Task</li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Data
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{route('tasks.create')}}" class="btn btn-info btn-sm ms-auto mb-3">New Task</a>
                </div>
                @if(session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
                @elseif(session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
                @endif

                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Assigned to</th>
                            <th>Due date</th>
                            <th>Status</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr>
                            <td>{{$task->title}}</td>
                            <td>{{$task->employee->name}}</td>
                            <td>{{$task->due_date}}</td>
                            <td>
                                @if($task->status == 'done')
                                    <span class="badge bg-success">Done</span>
                                @elseif($task->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-secondary">{{task->status}}</span>
                                @endif

                            </td>
                            <td>
                                <a href="{{route('tasks.show',$task->id)}}" class="btn btn-info btn-sm">View</a>
                                @if($task->status == 'done')
                                <a href="{{route('tasks.pending', $task->id)}}" class="btn btn-warning btn-sm">Mark as Pending</a>
                                @else
                                <a href="{{route('tasks.done', $task->id)}}" class="btn btn-success btn-sm"> Mark as Done</a>
                                @endif
                                <a href="{{route('tasks.edit',$task->id)}}" class="btn btn-secondary btn-sm">Edit</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>
@endsection
 