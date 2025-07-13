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
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Detail
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Title:</strong> {{ $task->title }}
                </div>
                <div class="mb-3">
                    <strong>Assigned to:</strong> {{ $task->employee->name }}
                </div>
                <div class="mb-3">
                    <strong>Due date:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('d-m-Y') }}
                </div>
                <div class="mb-3">
                    <strong>Status:</strong>
                    @if($task->status == 'done')
                        <span class="text-success">{{ $task->status }}</span>
                    @else
                        <span class="text-warning">{{ $task->status }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <strong>Description:</strong> {{ $task->description }}
                </div>
            </div>
        </div>
    </section>
@endsection
        