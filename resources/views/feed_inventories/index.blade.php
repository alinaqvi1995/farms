@extends('dashboard.includes.partial.base')

@section('title', 'Feed Inventory')

@section('content')
    <h6 class="mb-0 text-uppercase">Feed Inventory</h6>
    <hr>

    {{-- Add Feed Record button --}}
    @if (auth()->user()->isFarmAdmin() && $farm)
        <div class="mb-3 text-end">
            <a href="{{ route('feed_inventories.create', $farm->id) }}" class="btn btn-grd btn-grd-primary">
                <i class="material-icons-outlined">add</i> Add Feed Record
            </a>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Sr#</th>
                            <th>Entry Type</th>
                            <th>Feed Name</th>
                            <th>Quantity</th>
                            <th>Cost/Unit</th>
                            <th>Vendor</th>
                            <th>Date</th>
                            <th>Remarks</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feedRecords as $feed)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge {{ $feed->entry_type === 'stock_in' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst(str_replace('_', ' ', $feed->entry_type)) }}
                                    </span>
                                </td>
                                <td>{{ $feed->feed_name ?? '-' }}</td>
                                <td>{{ $feed->quantity }}</td>
                                <td>{{ $feed->cost_per_unit ?? '-' }}</td>
                                <td>{{ $feed->vendor ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($feed->date)->format('d M, Y') }}</td>
                                <td>{{ $feed->remarks ?? '-' }}</td>
                                <td>{{ $feed->creator_name ?? '-' }}</td>
                                <td>
                                    @if ($farm && auth()->user()->isFarmAdmin() && auth()->user()->farm_id === $feed->farm_id)
                                        <a href="{{ route('feed_inventories.edit', [$farm->id, $feed->id]) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="material-icons-outlined">edit</i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No feed records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="small text-muted">
                </div>
                <div>
                    {{ $feedRecords->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
    {{-- Optional JS for datatable --}}
@endsection
