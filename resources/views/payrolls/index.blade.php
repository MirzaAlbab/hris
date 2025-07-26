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
                <h3>Payrolls</h3>
                <p class="text-subtitle text-muted">Payrolls</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Payrolls</li>
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
                    <a href="{{route('payrolls.create')}}" class="btn btn-info btn-sm ms-auto mb-3">New payrolls</a>
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
                            <th>Salary</th>
                            <th>Allowance</th>
                            <th>Deduction</th>
                            <th>Net salary</th>
                            <th>Pay date</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payrolls as $payroll)
                        <tr>
                            <td>{{$payroll->employee->name}}</td>
                            <td>{{number_format($payroll->salary)}}</td>
                            <td>{{number_format($payroll->allowances)}}</td>
                            <td>{{number_format($payroll->deductions)}}</td>
                            <td>{{number_format($payroll->net_salary)}}</td>
                            <td>{{$payroll->pay_date}}</td>
                            <td>
                                <a href="{{route('payrolls.show',$payroll->id)}}" class="btn btn-info btn-sm">View</a>
                                <a href="{{route('payrolls.edit',$payroll->id)}}" class="btn btn-secondary btn-sm">Edit</a>
                                <form action="{{ route('payrolls.destroy', $payroll->id) }}" method="POST" class="d-inline">
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
 