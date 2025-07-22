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
                <h3>Employee</h3>
                <p class="text-subtitle text-muted">Employee data</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Employee</li>
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
                    <strong>Name:</strong> {{ $employee->name }}
                </div>
                <div class="mb-3">
                    <strong>Department:</strong> {{ $employee->department->name }}
                </div>
                <div class="mb-3">
                    <strong>Role:</strong> {{ $employee->role->title }}
                </div>
                <div class="mb-3">
                    <strong>Birth date:</strong> {{ \Carbon\Carbon::parse($employee->birth_date)->format('d-m-Y') }}
                </div>
                <div class="mb-3">
                    <strong>Email:</strong> {{ $employee->email }}
                </div>
                <div class="mb-3">
                    <strong>Phone:</strong> {{ $employee->phone }}
                </div>
                <div class="mb-3">
                    <strong>Address:</strong> {{ $employee->address }}
                </div>
                <div class="mb-3">
                    <strong>Hire date:</strong> {{ \Carbon\Carbon::parse($employee->hire_date)->format('d-m-Y') }}
                </div>
                <div class="mb-3">
                    <strong>Salary:</strong> {{ $employee->salary }}
                </div>
                <div class="mb-3">
                    <strong>Status:</strong>
                    @if($employee->status == 'active')
                        <span class="text-success">{{ $employee->status }}</span>
                    @else
                        <span class="text-secondary">{{ $employee->status }}</span>
                    @endif
                </div>
                <a href="{{route('employees.index')}}" class="btn btn-secondary"> Back to List</a>
            </div>
        </div>
    </section>
@endsection
        