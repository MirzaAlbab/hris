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
                <h3>Presences</h3>
                <p class="text-subtitle text-muted">Presences</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Presences</li>
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
                    <strong>Employee:</strong> {{ $presence->employee->name }}
                </div>
                <div class="mb-3">
                    <strong>Date:</strong> {{ $presence->date }}
                </div>
                <div class="mb-3">
                    <strong>Check in:</strong> {{ $presence->check_in }}
                </div>
                <div class="mb-3">
                    <strong>Check Out:</strong> {{ $presence->check_out }}
                </div>
                <div class="mb-3">
                    <strong>Status:</strong> {{ $presence->status }}
                </div>
                <a href="{{route('presences.index')}}" class="btn btn-secondary"> Back to List</a>
            </div>
        </div>
    </section>
@endsection
        