@extends('layouts.user_type.auth')

@section('content')
     <div class="row">
	<h6>Parts Quoted</h6>
        <div class="col-lg-6 col-12">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
              <div class="card">
                <span class="mask bg-primary opacity-10 border-radius-lg"></span>
                <div class="card-body p-3 position-relative">
                  <div class="row">
                    <div class="col-8 text-start">
                      <h4 class="text-white font-weight-bolder mb-0 mt-3">Today</h4>
                      <h5 class="text-white font-weight-bolder mb-0 mt-3">
                        You {{ $todayCountUser }}
                      </h5>
                      <span class="text-white text-sm">All {{ $todayCountAll }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12 mt-4 mt-md-0">
              <div class="card">
                <span class="mask bg-dark opacity-10 border-radius-lg"></span>
                <div class="card-body p-3 position-relative">
                  <div class="row">
                    <div class="col-8 text-start">
                      <h4 class="text-white font-weight-bolder mb-0 mt-3">Past Month</h4>
                      <h5 class="text-white font-weight-bolder mb-0 mt-3">
                        You {{ $monthCountUser }}
                      </h5>
                      <span class="text-white text-sm">All {{ $monthCountAll }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-lg-6 col-md-6 col-12">
              <div class="card">
                <span class="mask bg-dark opacity-10 border-radius-lg"></span>
                <div class="card-body p-3 position-relative">
                  <div class="row">
                    <div class="col-8 text-start">
                      <h4 class="text-white font-weight-bolder mb-0 mt-3">Past Year</h4>
                      <h5 class="text-white font-weight-bolder mb-0 mt-3">
                        You {{ $yearCountUser }}
                      </h5>
                      <span class="text-white text-sm">All {{ $yearCountAll  }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12 mt-4 mt-md-0">
              <div class="card">
                <span class="mask bg-dark opacity-10 border-radius-lg"></span>
                <div class="card-body p-3 position-relative">
                  <div class="row">
                    <div class="col-8 text-start">
                      <h4 class="text-white font-weight-bolder mb-0 mt-3">All Time</h4>
                      <h5 class="text-white font-weight-bolder mb-0 mt-3">
                        You {{ $totalCountUser }}
                      </h5>
                      <span class="text-white text-sm">All {{ $totalCountAll }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-12 mt-4 mt-lg-0">
          <div class="card z-index-2">

                <div class="card-body p-3">
                    <p class="text-sm mb-2 text-capitalize font-weight-bold">Parts Quoted (Past 30 days)</p>

                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@push('dashboard')

    <script>
        window.onload = function() {
            {{--const ctx = document.getElementById("chart-bars").getContext("2d");--}}

            {{--new Chart(ctx, {--}}
            {{--    type: "line",--}}
            {{--    data: {--}}
            {{--        labels: @json($dateRange->toArray()),--}}
            {{--        datasets: [{--}}
            {{--            label: "Number of Quotes",--}}
            {{--            tension: 0.4,--}}
            {{--            borderWidth: 0,--}}
            {{--            borderRadius: 4,--}}
            {{--            borderSkipped: false,--}}
            {{--            backgroundColor: "#5a5fe0 ",--}}
            {{--            data: @json($userQuotesByDay),--}}
            {{--            maxBarThickness: 6--}}
            {{--        }]--}}
            {{--    },--}}
            {{--    options: {--}}
            {{--        responsive: true,--}}
            {{--        maintainAspectRatio: false,--}}
            {{--        plugins: {--}}
            {{--            legend: {--}}
            {{--                display: false--}}
            {{--            }--}}
            {{--        },--}}
            {{--        interaction: {--}}
            {{--            intersect: false,--}}
            {{--            mode: "index"--}}
            {{--        },--}}
            {{--        scales: {--}}
            {{--            y: {--}}
            {{--                grid: {--}}
            {{--                    drawBorder: false,--}}
            {{--                    display: false,--}}
            {{--                    drawOnChartArea: false,--}}
            {{--                    drawTicks: false--}}
            {{--                },--}}
            {{--                ticks: {--}}
            {{--                    display: false,--}}
            {{--                    suggestedMin: 0,--}}
            {{--                    suggestedMax: 10,--}}
            {{--                    beginAtZero: true,--}}
            {{--                    padding: 15,--}}
            {{--                    font: {--}}
            {{--                        size: 14,--}}
            {{--                        family: "Open Sans",--}}
            {{--                        style: "normal",--}}
            {{--                        lineHeight: 2,--}}
            {{--                        color: "#fff"--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            },--}}
            {{--            x: {--}}
            {{--                grid: {--}}
            {{--                    drawBorder: false,--}}
            {{--                    display: false,--}}
            {{--                    drawOnChartArea: false,--}}
            {{--                    drawTicks: false--}}
            {{--                },--}}
            {{--                ticks: {--}}
            {{--                    display: false,--}}
            {{--                    font: {--}}
            {{--                        size: 14,--}}
            {{--                        family: "Open Sans",--}}
            {{--                        style: "normal",--}}
            {{--                        lineHeight: 2,--}}
            {{--                        color: "#fff"--}}
            {{--                    }--}}
            {{--                }--}}
            {{--            }--}}
            {{--        }--}}
            {{--    }--}}
            {{--});--}}


            const ctx2 = document.getElementById("chart-line").getContext("2d");

            const gradientStroke1 = ctx2.createLinearGradient(0, 0, 0, 200);

            gradientStroke1.addColorStop(0, "rgba(23, 193, 232, 0.2)");
            gradientStroke1.addColorStop(1, "rgba(23, 193, 232, 0.4)");

            const gradientStroke2 = ctx2.createLinearGradient(0, 0, 0, 200);

            gradientStroke2.addColorStop(0, "rgba(58, 65, 111, 0.2)");
            gradientStroke2.addColorStop(1, "rgba(58, 65, 111, 0.8)");


            const gradientStroke3 = ctx2.createLinearGradient(0, 0, 0, 200);

            gradientStroke3.addColorStop(0, "rgba(211, 211, 211, 0.2)");
            gradientStroke3.addColorStop(1, "rgba(211, 211, 211, 0.8)");


            // green
            const gradientStroke4 = ctx2.createLinearGradient(0, 0, 0, 200);

            gradientStroke4.addColorStop(0, "rgba(0, 128, 0, 0.1)"); // dark green
            gradientStroke4.addColorStop(1, "rgba(0, 128, 0, 0.4)"); // darker green


            new Chart(ctx2, {
                type: "line",
                data: {
                    labels: @json($dateRange->toArray()),
                    datasets: [{
                        label: "Parts Quoted (You)",
                        tension: 0.4,
                        borderWidth: 0,
                        pointRadius: 0,
                        borderColor: "#5a5fe0",
                        borderWidth: 3,
                        backgroundColor: gradientStroke1,
                        fill: true,
                        data: @json($userQuotesByDay),
                        maxBarThickness: 6

                    },
                        {
                            label: "Parts Quoted (All users)",
                            tension: 0.4,
                            borderWidth: 0,
                            pointRadius: 0,
                            borderColor: "#ccc",
                            borderWidth: 3,
                            backgroundColor: gradientStroke3,
                            fill: true,
                            data: @json($allQuotesByDay),
                            maxBarThickness: 6

                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: "index"
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                padding: 10,
                                color: "#b2b9bf",
                                font: {
                                    size: 11,
                                    family: "Open Sans",
                                    style: "normal",
                                    lineHeight: 2
                                }
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: false,
                                drawTicks: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                display: true,
                                color: "#b2b9bf",
                                padding: 20,
                                font: {
                                    size: 11,
                                    family: "Open Sans",
                                    style: "normal",
                                    lineHeight: 2
                                }
                            }
                        }
                    }
                }
            });
        };
    </script>
@endpush

