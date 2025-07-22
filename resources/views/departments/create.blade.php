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
                <h3>Department</h3>
                <p class="text-subtitle text-muted">Employee Department</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Department</li>
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
                <form action="{{ route('departments.store')}}" class="needs-validation" method="post">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter name" name="name" value="{{ old('name')}}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-2">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Enter description" id="description" name="description">{{old('description')}}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group mb-2">
                        <label for="status">Status</label>
                        <select type="text" class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="">Select status</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : ''}}>Inactive</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
        