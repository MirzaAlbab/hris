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
                @if(session('role') === "HR")
                <form action="{{ route('presences.store')}}" class="needs-validation" method="post">
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
                        <label for="date">Date</label>
                        <input type="datetime" class="form-control date @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date')}}">
                        @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="check_in">Check in</label>
                        <input type="datetime" class="form-control datetime @error('check_in') is-invalid @enderror" id="check_in" name="check_in" value="{{ old('check_in')}}">
                        @error('check_in')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="check_out">Check out</label>
                        <input type="datetime" class="form-control datetime @error('check_out') is-invalid @enderror" id="check_out" name="check_out" value="{{ old('check_out')}}">
                        @error('check_out')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                     <div class="form-group mb-2">
                        <label for="status">Status</label>
                        <select type="text" class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="">Select status</option>
                            <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="late" {{ old('status') == 'late' ? 'selected' : ''}}>Late</option>
                            <option value="absent" {{ old('status') == 'absent' ? 'selected' : ''}}>Absent</option>
                        </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('presences.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </form>
                @endif
                @if(session('role') !== "HR")
                    <form action="{{ route('presences.store')}}" class="needs-validation" method="post">
                        @csrf
                        <div class="mb-3">
                            <b>Note:</b>: Mohon ijinkan akses lokasi pada browser agar bisa melakukan presensi.
                        </div>
                        <div class="form-group mb-2">
                            <label for="latitude">Check in</label>
                            <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude')}}">
                        </div>
                        
                        <div class="form-group mb-2">
                            <label for="longitude">Check in</label>
                            <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude')}}">
                        </div>

                        <iframe src="" frameborder="0" id="map" width="500" height="400" scrolling="no">
                        </iframe>

                        <div class="mb-">
                            <button type="submit" class="btn btn-primary" id="btn-present" disabled>Present</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <script>
        const iframe = document.getElementById('map');

        const ofcLat = -7.270672447816188;
        const ofcLon = 112.75980492436126;
        const threshold = 0.01;

        navigator.geolocation.getCurrentPosition((position) =>{
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            iframe.src = `https://maps.google.com/maps?q=${lat},${lon}&output=embed`;
        });

        document.addEventListener('DOMContentLoaded', (event) =>{
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition((position) =>{
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lon;

                   const distance = Math.sqrt(Math.pow(lat - ofcLat, 2)+ Math.pow(lon - ofcLon, 2));

                   if (distance <= threshold){
                    alert('Kamu berada di kantor, selamat bekerja');
                    document.getElementById('btn-present').removeAttribute('disabled');
                   }else{
                    alert("Kamu tidak berada di kantor, silakan ke kantor untuk presensi ")
                   }
                })
            }
        })
    </script>
@endsection
        