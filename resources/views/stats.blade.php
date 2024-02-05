@extends('layouts.layout')

@section('content')
    <div class="container mt-md-5">
        <h2>Stats</h2>
        <a href="{{ route('visits.index') }}" class="btn btn-outline-dark">View Visits</a>

        <div class="row">
            <div class="col-md-6">
                <canvas id="hourlyVisitsChart" width="400" height="200"></canvas>
            </div>
            <div class="col-md-6">
                <div id="cityDistributionChart" style="width: 300px; height: 300px;"></div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const hourlyStats = @json($hourlyStats);
                const labels = hourlyStats.map(entry => entry.hour);
                const data = hourlyStats.map(entry => entry.total);

                const hourlyData = {
                    labels: labels,
                    datasets: [{
                        label: 'Visits by Hour',
                        data: data,
                        fill: false,
                        borderColor: 'rgba(132, 132, 132, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(132, 132, 132, 1)',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }]
                };

                const ctx = document.getElementById('hourlyVisitsChart').getContext('2d');
                const hourlyVisitsChart = new Chart(ctx, {
                    type: 'line',
                    data: hourlyData,
                    options: {
                        scales: {
                            x: {
                                type: 'category',
                                labels: labels,
                                title: {
                                    display: true,
                                    text: 'Time (h)'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Unique Visits'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });

                // Круговая диаграмма
                const cityData = @json($cityStats);
                const cityDistributionChart = d3.select('#cityDistributionChart')
                    .append('svg')
                    .attr('width', 300)
                    .attr('height', 300)
                    .append('g')
                    .attr('transform', 'translate(150,150)');

                const pie = d3.pie().value(d => d.total);
                const arc = d3.arc().innerRadius(0).outerRadius(150);

                const arcs = cityDistributionChart.selectAll('arc')
                    .data(pie(cityData))
                    .enter()
                    .append('g');

                arcs.append('path')
                    .attr('d', arc)
                    .attr('fill', (d, i) => d3.schemeCategory10[i]);

                arcs.append('text')
                    .attr('transform', d => `translate(${arc.centroid(d)})`)
                    .attr('text-anchor', 'middle')
                    .text(d => d.data.city);
            });
        </script>
    </div>
@endsection
