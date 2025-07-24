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
                <h3>Role</h3>
                <p class="text-subtitle text-muted">Employee Role</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Role</li>
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
                <form action="{{ route('roles.update',$role->id)}}" class="needs-validation" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2">
                        <label for="title">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter title" name="title" value="{{ old('title', $role->title)}}">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-2">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Enter description" id="description" name="description">{{$role->description}}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
        