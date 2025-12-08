@extends('dashboard.includes.partial.base')
@section('title', 'Animal Details')

@section('content')
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

        {{-- Milk Stats Dashboard --}}
        <div class="col-12 mb-3">
            <div class="row">

                {{-- Today Milk --}}
                <div class="col-md-4">
                    <div class="card shadow-sm border-left-primary">
                        <div class="card-body">
                            <h6 class="text-muted mb-1">Today's Milk</h6>
                            <h3 class="fw-bold">{{ number_format($todayMilk, 2) }} L</h3>
                        </div>
                    </div>
                </div>

                {{-- Yesterday milk + % diff --}}
                <div class="col-md-4">
                    <div class="card shadow-sm border-left-info">
                        <div class="card-body">
                            <h6 class="text-muted mb-1">Yesterday</h6>
                            <h3 class="fw-bold">{{ number_format($yesterdayMilk, 2) }} L</h3>

                            @if ($milkDiffPercent > 0)
                                <span class="text-success fw-bold">
                                    ↑ {{ number_format($milkDiffPercent, 1) }}%
                                </span>
                            @elseif ($milkDiffPercent < 0)
                                <span class="text-danger fw-bold">
                                    ↓ {{ number_format(abs($milkDiffPercent), 1) }}%
                                </span>
                            @else
                                <span class="text-muted fw-bold">No Change</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Mini Comparison Graph --}}
                <div class="col-md-4">
                    <div class="card shadow-sm border-left-warning">
                        <div class="card-body">
                            <h6 class="text-muted mb-1">Comparison</h6>

                            {{-- Simple bar chart --}}
                            @php
                                $max = max($todayMilk, $yesterdayMilk, 1);
                                $tWidth = ($todayMilk / $max) * 100;
                                $yWidth = ($yesterdayMilk / $max) * 100;
                            @endphp

                            <div class="mb-2">
                                <small>Today</small>
                                <div style="height:8px; background:#e0e0e0;">
                                    <div style="width:{{ $tWidth }}%; height:8px;"></div>
                                </div>
                            </div>

                            <div>
                                <small>Yesterday</small>
                                <div style="height:8px; background:#e0e0e0;">
                                    <div style="width:{{ $yWidth }}%; height:8px; background:#999;"></div>
                                </div>
                            </div>

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

        @foreach ($subpanels as $title => $records)
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
        @endforeach

    </div>
@endsection
