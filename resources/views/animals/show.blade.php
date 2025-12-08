@extends('dashboard.includes.partial.base')
@section('title', 'Animal Details')

@section('content')
    @php use Illuminate\Support\Str; @endphp
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Dashboard</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('farms.index') }}">Farms</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('farms.show', $animal->farm->id) }}">{{ $animal->farm->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $animal->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    @php $currentUser = auth()->user(); @endphp


    <div class="row">

        <div class="col-12 mb-3">
            <div class="row">

                <div class="col-md-6">
                    <div class="card shadow-sm" style="border-left: 5px solid #4e73df;">
                        <div class="card-body d-flex justify-content-between align-items-center">

                            <div>
                                <div class="text-muted small mb-1">Today's Milk</div>

                                <div style="font-size: 32px; font-weight: 700;">
                                    {{ number_format($todayMilk, 2) }} L
                                </div>

                                <div class="text-muted mt-1" style="font-size: 14px;">
                                    Yesterday: <strong>{{ number_format($yesterdayMilk, 2) }} L</strong>
                                </div>
                            </div>

                            <div class="text-end">
                                @if ($milkDiffPercent > 0)
                                    <div class="text-success fw-bold" style="font-size: 22px;">
                                        ↑ {{ number_format($milkDiffPercent, 1) }}%
                                    </div>
                                    <div class="small text-muted">Improved</div>
                                @elseif ($milkDiffPercent < 0)
                                    <div class="text-danger fw-bold" style="font-size: 22px;">
                                        ↓ {{ number_format(abs($milkDiffPercent), 1) }}%
                                    </div>
                                    <div class="small text-muted">Dropped</div>
                                @else
                                    <div class="text-muted fw-bold" style="font-size: 22px;">
                                        — 0%
                                    </div>
                                    <div class="small text-muted">No change</div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm" style="border-left: 5px solid #1cc88a;">
                        <div class="card-body">

                            <div class="text-muted small mb-1">Monthly Milk Trend</div>

                            <canvas id="monthlyMilkChart" height="100"></canvas>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Animal Info Panel -->
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white">Animal Information</h5>
                    @if ($currentUser->isSuperAdmin() || ($currentUser->isFarmAdmin() && $currentUser->farm_id == $animal->farm_id))
                        <div class="btn-group" role="group">
                            <a href="{{ route('animals.edit', $animal->id) }}" class="btn btn-light btn-sm">
                                <i class="material-icons-outlined">edit</i> Edit
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><strong>Name:</strong> {{ $animal->name }}</div>
                        <div class="col-md-6"><strong>Tag #:</strong> {{ $animal->tag_number ?? '-' }}</div>
                        <div class="col-md-6"><strong>Type:</strong> {{ $animal->type ?? '-' }}</div>
                        <div class="col-md-6"><strong>Breed:</strong> {{ $animal->breed ?? '-' }}</div>
                        <div class="col-md-6"><strong>Gender:</strong> {{ $animal->gender ?? '-' }}</div>
                        <div class="col-md-6"><strong>Color:</strong> {{ $animal->color ?? '-' }}</div>
                        <div class="col-md-6"><strong>Birth Date:</strong>
                            {{ $animal->birth_date ? \Carbon\Carbon::parse($animal->birth_date)->format('d M, Y') : '-' }}
                        </div>
                        <div class="col-md-6"><strong>Source:</strong> {{ $animal->source ?? '-' }}</div>
                        <div class="col-md-6"><strong>Purchase Price:</strong> {{ $animal->purchase_price ?? '-' }}</div>
                        <div class="col-md-6"><strong>Purchase Date:</strong>
                            {{ $animal->purchase_date ? \Carbon\Carbon::parse($animal->purchase_date)->format('d M, Y') : '-' }}
                        </div>
                        <div class="col-md-6"><strong>Vendor:</strong> {{ $animal->vendor ?? '-' }}</div>
                        <div class="col-md-12"><strong>Health Status:</strong> {{ $animal->health_status ?? '-' }}</div>
                        <div class="col-12"><strong>Notes:</strong> {{ $animal->notes ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subpanels -->
        @php
            $subpanels = [
                'Milk Production' => $animal->milkProductions,
                'Reproductions' => $animal->reproductions,
                'Calves' => $animal->calves,
                'Health Checks' => $animal->healthChecks,
                'Vaccinations' => $animal->vaccinations,
                'Treatments' => $animal->treatments,
                'Diseases' => $animal->diseases,
            ];
        @endphp

        <!-- AJAX Subpanels -->
        @foreach ($subpanels as $title => $relation)
            <div class="col-12">
                <div class="card mb-3 subpanel-card">
                    <div class="card-header bg-info d-flex justify-content-between align-items-center subpanel-toggle"
                        data-panel="{{ Str::slug($title) }}">
                        <h5 class="mb-0 text-white">{{ $title }}</h5>
                        <span class="text-white toggle-arrow">▼</span>
                    </div>
                    <div class="card-body subpanel-body" id="panel-{{ Str::slug($title) }}" style="display:none;">
                        <div class="mb-2">
                            <input type="text" class="form-control form-control-sm subpanel-search"
                                placeholder="Search..." data-panel="{{ Str::slug($title) }}">
                        </div>
                        <div class="subpanel-loading" style="display:none;">Loading...</div>
                        <div class="subpanel-content"></div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- @foreach ($subpanels as $title => $records)
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-header bg-info">
                        <h5 class="mb-0 text-white">{{ $title }}</h5>
                    </div>
                    <div class="card-body">
                        @if ($records->count())
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            @foreach (array_keys($records->first()->getAttributes()) as $field)
                                                <th>{{ ucfirst(str_replace('_', ' ', $field)) }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($records as $record)
                                            <tr>
                                                @foreach ($record->getAttributes() as $value)
                                                    <td>{{ $value }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>No records found.</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach --}}

    </div>
@endsection

@section('extra_js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('monthlyMilkChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyLabels) !!},
                datasets: [{
                    label: "Milk (L)",
                    data: {!! json_encode($monthlyValues) !!},
                    borderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        $(document).on('click', '.subpanel-toggle', function() {
            const panel = $(this).data('panel');
            const body = $('#panel-' + panel);
            const arrow = $(this).find('.toggle-arrow');
            const content = body.find('.subpanel-content');
            const loading = body.find('.subpanel-loading');

            if (body.is(':visible')) {
                body.slideUp(200);
                arrow.text('▼');
                return;
            }

            body.slideDown(200);
            arrow.text('▲');

            loadPanel(panel, content, loading);
        });

        $(document).on('keyup', '.subpanel-search', function() {
            const panel = $(this).data('panel');
            const query = $(this).val();
            const body = $('#panel-' + panel);
            const content = body.find('.subpanel-content');
            const loading = body.find('.subpanel-loading');

            loadPanel(panel, content, loading, 1, query);
        });

        function loadPanel(panel, content, loading, page = 1, search = '') {
            loading.show();

            $.get("{{ url('/animal/' . $animal->id) }}/" + panel, {
                page: page,
                search: search
            }, function(result) {
                loading.hide();
                content.html(result.html);

                // intercept pagination links via AJAX
                content.find('.pagination a').off('click').on('click', function(e) {
                    e.preventDefault();
                    const pageNum = $(this).data('page') || $(this).attr('href').split('page=')[1];
                    loadPanel(panel, content, loading, pageNum, search);
                });
            });
        }


        // function loadPanel(panel, content, loading, page = 1) {
        //     loading.show();

        //     $.get("{{ url('/animal/' . $animal->id) }}/" + panel, {
        //         page: page
        //     }, function(result) {
        //         loading.hide();
        //         content.html(result.html);
        //     });
        // }

        // delegate all pagination clicks for subpanels
        $(document).on('click', '.subpanel-content .pagination a', function(e) {
            e.preventDefault();
            const panel = $(this).closest('.subpanel-body').attr('id').replace('panel-', '');
            const content = $('#panel-' + panel).find('.subpanel-content');
            const loading = $('#panel-' + panel).find('.subpanel-loading');
            const pageNum = $(this).data('page');
            loadPanel(panel, content, loading, pageNum);
        });
    </script>
@endsection
