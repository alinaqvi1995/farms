@extends('dashboard.includes.partial.base')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Milk Production Report</h4>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET" action="{{ route('reports.production') }}" class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="{{ $startDate }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="{{ $endDate }}">
                                </div>
                                @if (isset($farms) && count($farms) > 0)
                                    <div class="col-md-3">
                                        <label for="farm_id" class="form-label">Farm</label>
                                        <select class="form-select" name="farm_id" id="farm_id">
                                            <option value="">All Farms</option>
                                            @foreach ($farms as $farm)
                                                <option value="{{ $farm->id }}"
                                                    {{ isset($farmId) && $farmId == $farm->id ? 'selected' : '' }}>
                                                    {{ $farm->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('reports.production') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Production</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ number_format($totalProduction, 2) }}
                                        <span class="text-muted fs-13">Liters</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Avg Daily</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                        {{ number_format($avgDailyProduction, 2) }} <span
                                            class="text-muted fs-13">Liters</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Production Records</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Animal</th>
                                            <th>Session</th>
                                            <th>Liters</th>
                                            <th>Recorded By</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($productionData as $item)
                                            <tr>
                                                <td>{{ $item->recorded_at->format('Y-m-d') }}</td>
                                                <td>{{ $item->animal ? $item->animal->tag : 'N/A' }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $item->session == 'morning' ? 'bg-warning' : ($item->session == 'evening' ? 'bg-info' : 'bg-primary') }}">
                                                        {{ ucfirst($item->session) }}
                                                    </span>
                                                </td>
                                                <td>{{ $item->litres }}</td>
                                                <td>{{ $item->user ? $item->user->name : '-' }}</td>
                                                <td>{{ $item->notes }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
