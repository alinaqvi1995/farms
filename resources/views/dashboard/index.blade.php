@extends('dashboard.includes.partial.base')
@section('title', 'Control Center Dashboard')
@section('content')
    <div class="container-fluid">

        <!-- Top Stats -->
        <div class="row mb-4">
            <!-- Daily Milk Production (Big Card) -->
            @if (auth()->user()->isFarmAdmin())
                <div class="{{ auth()->user()->hasRole('super_admin') ? 'col-xl-6' : 'col-xl-8' }} col-md-12 mb-3">
                    <div class="card bg-info text-white rounded-4 shadow-lg p-4">
                        <div class="card-body text-center">
                            <h1 class="display-2 fw-bold">{{ $milkToday }} L</h1>
                            <p class="h4 mb-3">Milk Today</p>
                            <small class="fs-5">
                                @if ($milkTrend == 'up')
                                    <span class="text-success fw-bold">&#9650; {{ $milkChangePercent }}% from
                                        yesterday</span>
                                @elseif($milkTrend == 'down')
                                    <span class="text-danger fw-bold">&#9660; {{ abs($milkChangePercent) }}% from
                                        yesterday</span>
                                @else
                                    <span class="text-light fw-bold">&#8212; No Change</span>
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Users -->
            <div class="{{ auth()->user()->hasRole('super_admin') ? 'col-xl-3' : 'col-xl-4' }} col-md-6 mb-3">
                <div class="card bg-primary text-white rounded-4 shadow-sm">
                    <div class="card-body text-center">
                        <h1 class="fw-bold">{{ $userCount }}</h1>
                        <p class="mb-0">Users</p>
                    </div>
                </div>
            </div>

            <!-- Farms (Superadmin Only) -->
            @if (auth()->user()->isSuperAdmin())
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card bg-success text-white rounded-4 shadow-sm">
                        <div class="card-body text-center">
                            <h1 class="fw-bold">{{ $farmCount }}</h1>
                            <p class="mb-0">Farms</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Animals / Latest Users / KPIs -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-3">
                <div class="card bg-warning text-white rounded-4 shadow-sm">
                    <div class="card-body text-center">
                        <h1 class="fw-bold">{{ $animalCount }}</h1>
                        <p class="mb-0">Animals</p>
                    </div>
                </div>
            </div>

            <!-- Latest Users -->
            <div class="col-xl-4 col-md-6 mb-3">
                <div class="card rounded-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Latest Users</h5>
                        <ul class="list-unstyled">
                            @foreach (\App\Models\User::latest()->take(5)->get() as $user)
                                <li class="d-flex align-items-center gap-2 mb-2">
                                    <img src="https://placehold.co/45x45/png" class="rounded-circle" alt="">
                                    <span>{{ $user->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Animals Overview / KPIs -->
            <div class="col-xl-4 col-md-12 mb-3">
                <div class="card rounded-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Animals Overview</h5>
                        <div class="d-flex justify-content-between">
                            <p>Total Animals</p>
                            <p>{{ $animalCount }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>New This Month</p>
                            <p>{{ \App\Models\Animal::whereMonth('created_at', now()->month)->count() }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Avg Milk per Animal</p>
                            <p>{{ number_format($milkToday / max($animalCount, 1), 2) }} L</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Growth & Milk Trend Charts -->
        <div class="row mb-4">
            <div class="{{ auth()->user()->hasRole('super_admin') ? 'col-xl-4' : 'col-xl-6' }} col-md-6 mb-3">
                <div class="card rounded-4 shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">User Growth (Last 7 Days)</h5>
                    </div>
                    <div class="card-body">
                        <div id="userGrowthChart" style="height: 200px;"></div>
                    </div>
                </div>
            </div>

            @if (auth()->user()->hasRole('super_admin'))
                <div class="col-xl-4 col-md-6 mb-3">
                    <div class="card rounded-4 shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Farm Growth (Last 7 Days)</h5>
                        </div>
                        <div class="card-body">
                            <div id="farmGrowthChart" style="height: 200px;"></div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="{{ auth()->user()->hasRole('super_admin') ? 'col-xl-4' : 'col-xl-6' }} col-md-12 mb-3">
                <div class="card rounded-4 shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Milk Production Trend (Last 7 Days)</h5>
                    </div>
                    <div class="card-body">
                        <div id="milkTrendChart" style="height: 200px;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('admin/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script>
        // User Growth Chart
        new ApexCharts(document.querySelector("#userGrowthChart"), {
            chart: {
                type: 'line',
                height: 200
            },
            series: [{
                name: 'Users',
                data: @json(array_values($usersLast7Days->toArray()))
            }],
            xaxis: {
                categories: @json(array_keys($usersLast7Days->toArray()))
            }
        }).render();

        // Farm Growth Chart (Superadmin only)
        @if (auth()->user()->hasRole('super_admin'))
            new ApexCharts(document.querySelector("#farmGrowthChart"), {
                chart: {
                    type: 'line',
                    height: 200
                },
                series: [{
                    name: 'Farms',
                    data: @json(array_values($farmsLast7Days->toArray()))
                }],
                xaxis: {
                    categories: @json(array_keys($farmsLast7Days->toArray()))
                }
            }).render();
        @endif

        // Milk Trend Chart
        new ApexCharts(document.querySelector("#milkTrendChart"), {
            chart: {
                type: 'line',
                height: 200
            },
            series: [{
                name: 'Milk (L)',
                data: @json(array_values($milkLast7Days->toArray()))
            }],
            xaxis: {
                categories: @json(array_keys($milkLast7Days->toArray()))
            }
        }).render();
    </script>
@endsection
