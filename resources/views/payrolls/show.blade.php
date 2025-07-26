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
                <div id="printableArea">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Name:</strong> {{ $payroll->employee->name }}
                            </div>
                            <div class="mb-3">
                                <strong>Salary:</strong> {{ number_format($payroll->salary) }}
                            </div>
                            <div class="mb-3">
                                <strong>Allowance:</strong> {{ number_format($payroll->allowances) }}
                            </div>
                            <div class="mb-3">
                                <strong>Deduction:</strong> {{ number_format($payroll->deductions) }}
                            </div>
                        </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong>Net salary:</strong> {{ number_format($payroll->net_salary) }}
                                </div>
                                <div class="mb-3">
                                    <strong>Pay date:</strong> {{ \Carbon\Carbon::parse($payroll->pay_date)->format('d F Y') }}
                                </div>
                            </div>
                    </div>
                </div>
                

                
                
                <a href="{{route('payrolls.index')}}" class="btn btn-secondary"> Back to List</a>
                <button type="button" id="btn-print" class="btn btn-info"><span class="bi bi-printer"></span> Print</button>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('btn-print').addEventListener('click', function(){
            let printContents = document.getElementById('printableArea').innerHTML;
            let originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        })
    </script>
@endsection
        