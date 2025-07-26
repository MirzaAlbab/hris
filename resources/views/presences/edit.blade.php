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
                <h3>Presence</h3>
                <p class="text-subtitle text-muted">Employee Presence</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Presence</li>
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
                <form action="{{ route('presences.update',$presence->id)}}" class="needs-validation" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2">
                        <label for="employee">Employee</label>
                        <select type="text" class="form-control @error('employee_id') is-invalid @enderror" id="employee" name="employee_id">
                            <option value="">Select employee</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id', $presence->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                            @endforeach
                        </select>
                        @error('employee_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <div class="form-group mb-2">
                        <label for="date">Date</label>
                        <input type="datetime" class="form-control date @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date',$presence->date)}}">
                        @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="check_in">Check in</label>
                        <input type="datetime" class="form-control datetime @error('check_in') is-invalid @enderror" id="check_in" name="check_in" value="{{ old('check_in',$presence->check_in)}}">
                        @error('check_in')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="check_out">Check out</label>
                        <input type="datetime" class="form-control datetime @error('check_out') is-invalid @enderror" id="check_out" name="check_out" value="{{ old('check_out',$presence->check_out)}}">
                        @error('check_out')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                     <div class="form-group mb-2">
                        <label for="status">Status</label>
                        <select type="text" class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="">Select status</option>
                            <option value="present" {{ old('status',$presence->status) == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="late" {{ old('status',$presence->status) == 'late' ? 'selected' : ''}}>Late</option>
                            <option value="absent" {{ old('status',$presence->status) == 'absent' ? 'selected' : ''}}>Absent</option>
                            <option value="leave" {{ old('status',$presence->status) == 'leave' ? 'selected' : ''}}>Leave</option>
                        </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>



                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('presences.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
        