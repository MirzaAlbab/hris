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
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Edit
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('tasks.update', $task->id)}}" class="needs-validation" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2">
                        <label for="title">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter title" name="title" value="{{ old('title',$task->title)}}">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-2">
                        <label for="employee">Employee</label>
                        <select type="text" class="form-control @error('assigned_to') is-invalid @enderror" id="employee" name="assigned_to">
                            <option value="">Select employee</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee',$task->assigned_to) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="due_date">Due date</label>
                        <input type="datetime" class="form-control date @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date',$task->due_date)}}">
                        @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="status">Status</label>
                        <select type="text" class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="">Select status</option>
                            <option value="pending" {{ old('status',$task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="on_progress" {{ old('status',$task->status) == 'on_progress' ? 'selected' : ''}}>On Progress</option>
                        </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Enter description" id="description">{{old('description', $task->description)}}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
        