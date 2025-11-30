@extends('dashboard.includes.partial.base')
@section('title', 'Add Feed Inventory Record')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Dashboard</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('feed_inventories.index', $farm->id) }}">Feed Inventory</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Feed</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('feed_inventories.store', $farm->id) }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- Top Buttons -->
                    <div class="card-header d-flex justify-content-between align-items-center bg-primary">
                        <h5 class="mb-0 text-white">Add Feed Record</h5>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-light btn-sm">
                                <i class="material-icons-outlined">save</i> Save
                            </button>
                            <a href="{{ route('feed_inventories.index', $farm->id) }}" class="btn btn-light btn-sm">
                                <i class="material-icons-outlined">cancel</i> Cancel
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Entry Type <span class="text-danger">*</span></label>
                                <select name="entry_type" class="form-select" required>
                                    <option value="stock_in" {{ old('entry_type') == 'stock_in' ? 'selected' : '' }}>Stock
                                        In</option>
                                    <option value="consumption" {{ old('entry_type') == 'consumption' ? 'selected' : '' }}>
                                        Consumption</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Feed Name</label>
                                <input type="text" name="feed_name" value="{{ old('feed_name') }}" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="quantity" value="{{ old('quantity') }}"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cost per Unit</label>
                                <input type="number" step="0.01" name="cost_per_unit" value="{{ old('cost_per_unit') }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Vendor</label>
                                <input type="text" name="vendor" value="{{ old('vendor') }}" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="remarks" value="{{ old('remarks') }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Buttons -->
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="material-icons-outlined">save</i> Save
                        </button>
                        <a href="{{ route('feed_inventories.index', $farm->id) }}" class="btn btn-secondary px-4">
                            <i class="material-icons-outlined">cancel</i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
