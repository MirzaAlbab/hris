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
                    <a href="{{route('leave-requests.create')}}" class="btn btn-info btn-sm ms-auto mb-3">New Leave request</a>
                </div>
                @if(session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
                @elseif(session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
                @endif

                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Start date</th>
                            <th>End date</th>
                            <th>Status</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaveRequests as $leaveRequest)
                        <tr>
                            <td>{{$leaveRequest->employee->name}}</td>
                            <td>{{$leaveRequest->type}}</td>
                            <td>{{$leaveRequest->start_date}}</td>
                            <td>{{$leaveRequest->end_date}}</td>
                            <td>
                                @if($leaveRequest->status == 'approved')
                                    <span class="badge bg-success">{{ucfirst($leaveRequest->status)}}</span>
                                @else
                                    <span class="badge bg-warning">{{ucfirst($leaveRequest->status)}}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('leave-requests.show',$leaveRequest->id)}}" class="btn btn-info btn-sm">View</a>
                                <a href="{{route('leave-requests.edit',$leaveRequest->id)}}" class="btn btn-secondary btn-sm">Edit</a>
                                <form action="{{ route('leave-requests.destroy', $leaveRequest->id) }}" method="POST" class="d-inline">
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
 