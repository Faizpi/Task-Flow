@extends('layouts.app')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container mt-5 p-2">
    <h1 class="text-start text-primary mb-4" style="font-size: 2rem; font-weight: bold;">Dashboard Statistik</h1>
    <div class="row align-items-center g-1 shadow-sm p-2 rounded" style="backdrop-filter: blur(5px); background-color: rgba(255, 255, 255, 0.5); border-radius: 20px">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Total Tugas:</strong>
                            <span class="badge bg-primary rounded-pill statistic-badge">{{ $totalTasks }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Tugas Selesai:</strong>
                            <span class="badge bg-success rounded-pill statistic-badge">{{ $completedTasks }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>Tugas Belum Selesai:</strong>
                            <span class="badge bg-danger rounded-pill statistic-badge">{{ $pendingTasks }}</span>
                        </li>
                    </ul>
                    <!-- Add a canvas element for the chart -->
                    <canvas id="taskChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-5">
        <a href="{{ route('tasks.index') }}" class="btn btn-primary btn-lg btn-custom">Lihat Daftar Tugas</a>
    </div>
</div>

@endsection

{{-- Tambahkan CSS --}}
<style>
    body {
        position: relative;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset('images/background.png') }}'); 
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        filter: blur(8px);
        z-index: -1;
    }

    .container {
        position: relative;
        z-index: 1;
    }

    .btn-custom {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: auto;
        padding: 10px 20px;
        margin-top: 10px;
        background: linear-gradient(90deg, #ff9a9e, #fad0c4);
        border: none;
        border-radius: 8px;
        color: white;
        font-size: 16px;
        font-weight: bold;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-custom:hover {
        background: linear-gradient(90deg, #fbc2eb, #a6c1ee);
        transform: scale(1.02);
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
    }

    .statistic-badge {
        padding-left: 10px;
        font-size: 1.2rem; 
    }

    .card {
        border-radius: 20px;
    }

    .card-body {
        padding: 20px;
    }

    #taskChart {
        width: 100%;
        height: 500px; /* Ukuran lebih kecil (tinggi 150px) */
        max-width: 700px; /* Membatasi lebar maksimal */
        max-height: 600px; /* Membatasi tinggi maksimal */
        margin: 0 auto; /* Posisikan tengah */
    }
</style>

<script>
    window.onload = function() {
        const ctx = document.getElementById('taskChart').getContext('2d');
        const taskChart = new Chart(ctx, {
            type: 'line', 
            data: {
                labels: ['Total Tugas', 'Tugas Selesai', 'Tugas Belum Selesai'],
                datasets: [{
                    label: 'Statistik Tugas',
                    data: [{{ $totalTasks ?? 0 }}, {{ $completedTasks ?? 0 }}, {{ $pendingTasks ?? 0 }}],
                    borderColor: '#007bff',
                    borderWidth: 2,
                    fill: true 
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    };
</script>
