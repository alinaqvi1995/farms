@extends('dashboard.includes.partial.base')
@section('title', 'Farm Details')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Dashboard</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('farms.index') }}">Farms</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $farm->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Farm Info Panel -->
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white">Farm Information</h5>
                    @php $currentUser = auth()->user(); @endphp
                    @if ($currentUser->isSuperAdmin() || ($currentUser->isFarmAdmin() && $currentUser->farm_id == $farm->id))
                        <div class="btn-group" role="group">
                            <a href="{{ route('farms.edit', $farm->id) }}" class="btn btn-light btn-sm">
                                <i class="material-icons-outlined">edit</i> Edit
                            </a>
                            @if ($currentUser->isSuperAdmin())
                                <form action="{{ route('farms.destroy', $farm->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this farm?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="material-icons-outlined">delete</i>
                                        Delete</button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6"><strong>Name:</strong> {{ $farm->name }}</div>
                        <div class="col-md-6"><strong>Owner:</strong> {{ $farm->owner_name ?? '-' }}</div>
                        <div class="col-md-6"><strong>Phone:</strong> {{ $farm->phone ?? '-' }}</div>
                        <div class="col-md-6"><strong>Email:</strong> {{ $farm->email ?? '-' }}</div>
                        <div class="col-md-12"><strong>Address:</strong>
                            {{ implode(', ', array_filter([$farm->address, $farm->city, $farm->state, $farm->country, $farm->zipcode])) }}
                        </div>
                        <div class="col-md-6"><strong>Area:</strong> {{ $farm->area ?? '-' }}</div>
                        <div class="col-md-6"><strong>Established:</strong>
                            {{ $farm->established_at ? \Carbon\Carbon::parse($farm->established_at)->format('d M, Y') : '-' }}
                        </div>
                        <div class="col-md-6"><strong>Registration #:</strong> {{ $farm->registration_number ?? '-' }}
                        </div>
                        <div class="col-md-6"><strong>Status:</strong> {!! $farm->status
                            ? '<span class="badge bg-success">Active</span>'
                            : '<span class="badge bg-danger">Inactive</span>' !!}
                        </div>
                        <div class="col-12"><strong>Notes:</strong> {{ $farm->notes ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Subpanel -->
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header bg-secondary d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white">Users ({{ $farm->users()->count() }})</h5>
                </div>
                <div class="card-body">
                    @if ($farm->users->count())
                        <table class="table table-striped table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($farm->users as $user)
                                    <tr>
                                        <td><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>
                                        <td>{{ $user->email ?? '-' }}</td>
                                        <td>{{ $user->roles->pluck('name')->join(', ') ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="mb-0">No users assigned.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Animals Subpanel -->
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header bg-secondary d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white">Animals ({{ $farm->animals()->count() }})</h5>
                </div>
                <div class="card-body">
                    @if ($farm->animals->count())
                        <table class="table table-striped table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Breed</th>
                                    <th>Birth Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($farm->animals as $animal)
                                    <tr>
                                        <td><a href="{{ route('animals.show', $animal->id) }}">{{ $animal->name }}</a>
                                        </td>
                                        <td>{{ $animal->type ?? '-' }}</td>
                                        <td>{{ $animal->breed ?? '-' }}</td>
                                        <td>{{ $animal->birth_date ? \Carbon\Carbon::parse($animal->birth_date)->format('d M, Y') : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="mb-0">No animals in this farm.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header bg-success d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white">Feed Inventory</h5>
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#feedModal">
                        <i class="material-icons-outlined">add</i> Add Entry
                    </button>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($farm->feedInventories as $feed)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ ucfirst($feed->entry_type) }} - {{ $feed->quantity }} kg
                                ({{ $feed->feed_name ?? 'N/A' }})
                                - {{ $feed->date->format('d M, Y') }}
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#feedModal" data-id="{{ $feed->id }}">
                                    Edit
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="modal fade" id="feedModal" tabindex="-1" aria-labelledby="feedModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('feed_inventories.store') }}" id="feedForm">
                    @csrf
                    <input type="hidden" name="farm_id" value="{{ $farm->id }}">
                    <input type="hidden" name="id" id="feed_id">

                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="feedModalLabel">Add/Edit Feed Entry</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Entry Type</label>
                                <select name="entry_type" id="feed_entry_type" class="form-select" required>
                                    <option value="stock_in">Stock In</option>
                                    <option value="consumption">Consumption</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quantity (kg)</label>
                                <input type="number" step="0.01" name="quantity" id="feed_quantity"
                                    class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Feed Name</label>
                                <input type="text" name="feed_name" id="feed_name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cost Per Unit</label>
                                <input type="number" step="0.01" name="cost_per_unit" id="feed_cost_per_unit"
                                    class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Vendor</label>
                                <input type="text" name="vendor" id="feed_vendor" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" name="date" id="feed_date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Remarks</label>
                                <textarea name="remarks" id="feed_remarks" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
