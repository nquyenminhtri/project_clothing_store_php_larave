@extends('layout')
@section('content')
    <h1>Statistical Report</h1>

    <canvas id="lineChart" width="400" height="400"></canvas>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('lineChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["January", "February", "March", "April", "May", "June", "July"],
                    datasets: [{
                        label: 'Monthly Sales',
                        data: [12, 19, 3, 5, 2, 3, 15],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false,
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'linear',
                            position: 'bottom'
                        },
                        y: {
                            min: 0,
                        }
                    }
                }
            });
        });
    </script>
@endsection
