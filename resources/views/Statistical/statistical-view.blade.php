@extends('layout')

@section('content')
    <h1>Statistical View</h1>

    <h2>Daily Revenue</h2>
    <canvas id="dailyRevenueChart" width="400" height="200"></canvas>

    <h2>Weekly Revenue</h2>
    <canvas id="weeklyRevenueChart" width="400" height="200"></canvas>

    <h2>Monthly Revenue</h2>
    <canvas id="monthlyRevenueChart" width="400" height="200"></canvas>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctxDaily = document.getElementById('dailyRevenueChart').getContext('2d');
            var myChartDaily = new Chart(ctxDaily, {
                type: 'bar',
                data: {
                    labels: @json($dailyRevenue->keys()),
                    datasets: [{
                        label: 'Daily Revenue',
                        data: @json($dailyRevenue->values()),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'category',
                            position: 'bottom'
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var ctxWeekly = document.getElementById('weeklyRevenueChart').getContext('2d');
            var myChartWeekly = new Chart(ctxWeekly, {
                // ... (similar configuration for weekly chart)
            });

            var ctxMonthly = document.getElementById('monthlyRevenueChart').getContext('2d');
            var myChartMonthly = new Chart(ctxMonthly, {
                // ... (similar configuration for monthly chart)
            });
        });
    </script>
    @php
        $hideCardContent = true;
    @endphp
@endsection
