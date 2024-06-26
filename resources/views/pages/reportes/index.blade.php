@extends('reportes.layout')

@section('content-reportes')
    <header>
        Dashboard
    </header>
    <div class="container-fluid">
        <div class="w-[300px] h-[300px]">
            <canvas id="myChart"></canvas>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Red', 'Blue', 'Yellow'],
                datasets: [{
                    label: 'count',
                    data: [12, 19, 3],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
