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
                <p class="text-subtitle text-muted">Role</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Role</li>
                        <li class="breadcrumb-item active" aria-current="page">Index</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Data
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex">
                    <a href="{{route('roles.create')}}" class="btn btn-info btn-sm ms-auto mb-3">New role</a>
                </div>
                @if(session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
                @elseif(session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
                @endif

                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{$role->title}}</td>
                            <td>{{$role->description}}</td>
                            <td>
                                <a href="{{route('roles.show',$role->id)}}" class="btn btn-info btn-sm">View</a>
                                <a href="{{route('roles.edit',$role->id)}}" class="btn btn-secondary btn-sm">Edit</a>
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>
@endsection
 