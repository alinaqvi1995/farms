@extends('dashboard.includes.partial.base')
@section('title', 'Control Center Dashboard')

@section('content')
    <!-- Top Row: Premium Status Cards -->
    @if (auth()->user()->isFarmAdmin())
        <div class="row row-cols-1 row-cols-lg-2 mb-4">
            <!-- Milk Produced -->
            <div class="col">
                <div class="card rounded-4 border-0 shadow-sm overflow-hidden h-100">
                    <div class="card-body position-relative">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary notranslate"
                                style="width: 60px; height: 60px;">
                                <i class="material-icons-outlined fs-1">water_drop</i>
                            </div>
                            <div>
                                <p class="mb-0 text-secondary fw-bold text-uppercase small">Milk Produced Today</p>
                                <h3 class="my-1 fw-bold text-dark">{{ $milkToday }} L</h3>
                                @if ($milkTrend == 'up')
                                    <span class="badge bg-soft-success text-success"><i
                                            class="material-icons-outlined font-14 notranslate">trending_up</i>
                                        {{ $milkChangePercent }}%</span>
                                @elseif($milkTrend == 'down')
                                    <span class="badge bg-soft-danger text-danger"><i
                                            class="material-icons-outlined font-14 notranslate">trending_down</i>
                                        {{ abs($milkChangePercent) }}%</span>
                                @else
                                    <span class="badge bg-soft-secondary text-secondary">No Change</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>

            <!-- Milk Sold -->
            <div class="col">
                <div class="card rounded-4 border-0 shadow-sm overflow-hidden h-100">
                    <div class="card-body position-relative">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10 text-success notranslate"
                                style="width: 60px; height: 60px;">
                                <i class="material-icons-outlined fs-1">storefront</i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-0 text-secondary fw-bold text-uppercase small">Milk Sold Today</p>
                                <div class="d-flex align-items-baseline gap-2">
                                    <h3 class="my-1 fw-bold text-dark">{{ $salesToday }} L</h3>
                                </div>
                                <p class="mb-0 text-success fw-bold"><i
                                        class="material-icons-outlined font-14 notranslate">payments</i>
                                    PKR {{ number_format($revenueToday, 0) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Secondary Row: General KPIs -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mb-4">

        <div class="col">
            <div class="card rounded-4 border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-0 text-secondary small text-uppercase fw-bold">Total Animals</p>
                            <h4 class="my-1 fw-bold">{{ $animalCount }}</h4>
                        </div>
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-warning bg-opacity-10 text-warning notranslate"
                            style="width: 45px; height: 45px;">
                            <i class="material-icons-outlined fs-4">pets</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card rounded-4 border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-0 text-secondary small text-uppercase fw-bold">Total Users</p>
                            <h4 class="my-1 fw-bold">{{ $userCount }}</h4>
                        </div>
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-purple bg-opacity-10 text-purple notranslate"
                            style="width: 45px; height: 45px; color: #6f42c1;">
                            <i class="material-icons-outlined fs-4">group</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (auth()->user()->isSuperAdmin())
            <div class="col">
                <div class="card rounded-4 border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-0 text-secondary small text-uppercase fw-bold">Total Farms</p>
                                <h4 class="my-1 fw-bold">{{ $farmCount }}</h4>
                            </div>
                            <div class="d-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10 text-danger notranslate"
                                style="width: 45px; height: 45px;">
                                <i class="material-icons-outlined fs-4">agriculture</i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>


    <div class="row">
        <!-- Recent Milk Sales -->
        <div class="col-lg-8 d-flex">
            <div class="card w-100 rounded-4">
                <div class="card-header border-bottom bg-transparent">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Recent Milk Sales</h5>
                        @if (auth()->user()->isFarmAdmin())
                            <a href="{{ route('milk_sales.index') }}" class="btn btn-sm btn-primary"><i
                                    class="material-icons-outlined notranslate">add</i> Record Sale</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Vendor</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentSales as $sale)
                                    <tr>
                                        <td>{{ $sale->sold_at->format('d M H:i') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ $sale->vendor->name }}</h6>
                                                    <small class="text-secondary">{{ $sale->vendor->phone }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $sale->quantity }} L</td>
                                        <td>PKR {{ number_format($sale->total_amount, 0) }}</td>
                                        <td>
                                            @if ($sale->price_type == 'admin')
                                                <span class="badge bg-light-primary text-primary">Admin Price</span>
                                            @else
                                                <span class="badge bg-light-warning text-warning">Custom Price</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">No sales recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts (Simplified) -->
        <div class="col-lg-4 d-flex">
            <div class="card w-100 rounded-4">
                <div class="card-header border-bottom bg-transparent">
                    <h5 class="mb-0">Production Trend (7 Days)</h5>
                </div>
                <div class="card-body">
                    <div id="milkTrendChart" style="height: 250px;"></div>
                </div>
            </div>
        </div>

    </div>

    @if (auth()->user()->isSuperAdmin())
        <div class="row">
            <div class="col-lg-12">
                <div class="card rounded-4">
                    <div class="card-header border-bottom bg-transparent">
                        <h5 class="mb-0">Platform Growth</h5>
                    </div>
                    <div class="card-body">
                        <div id="userGrowthChart" style="height: 250px;"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <script src="{{ asset('admin/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script>
        // Milk Trend Chart
        var options = {
            series: [{
                name: "Milk Produced",
                data: @json(array_values($milkLast7Days->toArray()))
            }],
            chart: {
                type: 'area', // Changed to area for better look
                height: 250,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            colors: ["#0d6efd"],
            xaxis: {
                categories: @json(array_keys($milkLast7Days->toArray())),
            }
        };
        new ApexCharts(document.querySelector("#milkTrendChart"), options).render();

        // User Growth Chart (SuperAdmin)
        @if (auth()->user()->hasRole('super_admin'))
            var userOptions = {
                series: [{
                    name: "New Users",
                    data: @json(array_values($usersLast7Days->toArray()))
                }],
                chart: {
                    type: 'bar',
                    height: 250,
                    toolbar: {
                        show: false
                    }
                },
                colors: ["#6610f2"],
                xaxis: {
                    categories: @json(array_keys($usersLast7Days->toArray()))
                }
            };
            new ApexCharts(document.querySelector("#userGrowthChart"), userOptions).render();
        @endif
    </script>
@endsection
