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
                <h3>Leave request</h3>
                <p class="text-subtitle text-muted">Leave request</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Leave request</li>
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
                    <strong>Employee:</strong> {{ $leaveRequest->employee->name }}
                </div>
                <div class="mb-3">
                    <strong>Date:</strong> {{ $leaveRequest->type }}
                </div>
                <div class="mb-3">
                    <strong>Check in:</strong> {{ $leaveRequest->start_date }}
                </div>
                <div class="mb-3">
                    <strong>Check Out:</strong> {{ $leaveRequest->end_date }}
                </div>
                <div class="mb-3">
                    <strong>Status:</strong> 
                    @if($leaveRequest->status == 'approved')
                            <span class="badge bg-success">{{ucfirst($leaveRequest->status)}}</span>
                    @else
                                    <span class="badge bg-warning">{{ucfirst($leaveRequest->status)}}</span>
                    @endif
                </div>
                <a href="{{route('leave-requests.index')}}" class="btn btn-secondary"> Back to List</a>
            </div>
        </div>
    </section>
@endsection
        