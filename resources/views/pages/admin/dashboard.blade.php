@extends('layouts.admin')


@section('content')
<div class="container-fluid">

    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <!-- Card Total Tamu -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="card-title text-muted">Total Tamu</h5>
                    <h2 class="text-primary">{{ $totalResidents }}</h2>
                </div>
            </div>
        </div>

        <!-- Card Total Pelayanan -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <h5 class="card-title text-muted">Total Pelayanan</h5>
                    <h2 class="text-success">{{ $totalServices }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="card-title mb-4"></h5>
            <canvas id="dashboardChart" height="100"></canvas>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // const months = {!! json_encode($months) !!};
    // const residentData = {!! json_encode($residentData) !!};
    // const serviceData  = {!! json_encode($serviceData) !!};

    const ctx = document.getElementById('dashboardChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Tamu',
                    data: residentData,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Pelayanan',
                    data: serviceData,
                    borderColor: 'rgba(75, 192, 75, 1)',
                    backgroundColor: 'rgba(75, 192, 75, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush