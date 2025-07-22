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
                <p class="text-subtitle text-muted">Employee Data</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Employee</li>
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
                <form action="{{ route('employees.store')}}" class="needs-validation" method="post">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter name" name="name" value="{{ old('name')}}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="email">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter email" name="email" value="{{ old('email')}}">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" placeholder="Enter phone" name="phone" value="{{ old('phone')}}">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="address">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" placeholder="Enter address" id="address" name="address"></textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-2">
                        <label for="department">Department</label>
                        <select type="text" class="form-control @error('department_id') is-invalid @enderror" id="department" name="department_id">
                            <option value="">Select department</option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="role">Role</label>
                        <select type="text" class="form-control @error('role_id') is-invalid @enderror" id="role" name="role_id">
                            <option value="">Select role</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>{{ $role->title }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="birth_date">Birth date</label>
                        <input type="datetime" class="form-control date @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date')}}">
                        @error('birth_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="hire_date">Hire date</label>
                        <input type="datetime" class="form-control date @error('hire_date') is-invalid @enderror" id="hire_date" name="hire_date" value="{{ old('hire_date')}}">
                        @error('hire_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="status">Status</label>
                        <select type="text" class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="">Select status</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : ''}}>Active</option>
                        </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="salary">Salary</label>
                        <input type="number" class="form-control @error('salary') is-invalid @enderror" id="salary" placeholder="Enter salary" name="salary" value="{{ old('salary')}}">
                        @error('salary')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
        