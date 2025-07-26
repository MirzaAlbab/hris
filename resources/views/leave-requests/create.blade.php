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
                <p class="text-subtitle text-muted">Employee Leave request</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Leave request</li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Create
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('leave-requests.store')}}" class="needs-validation" method="post">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="employee">Employee</label>
                        <select type="text" class="form-control @error('employee_id') is-invalid @enderror" id="employee" name="employee_id">
                            <option value="">Select employee</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                            @endforeach
                        </select>
                        @error('employee_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="type">Type</label>
                        <select type="text" class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                            <option value="">Select type</option>
                            <option value="sick" {{ old('type') == 'sick' ? 'selected' : '' }}>Sick</option>
                            <option value="vacation" {{ old('type') == 'vacation' ? 'selected' : ''}}>Vacation</option>
                            <option value="birth" {{ old('type') == 'birth' ? 'selected' : ''}}>Birth</option>
                        </select>
                            @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>

                    
                    <div class="form-group mb-2">
                        <label for="start_date">Start date</label>
                        <input type="datetime" class="form-control date @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date')}}">
                        @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="end_date">End date</label>
                        <input type="datetime" class="form-control date @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date')}}">
                        @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('leave-requests.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
        