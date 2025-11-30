@extends('dashboard.includes.partial.base')
@section('title', 'Edit Farm')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Dashboard</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('farms.index') }}">Farms</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Farm</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('farms.update', $farm->id) }}" method="POST" enctype="multipart/form-data" id="farmForm">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- Top Buttons -->
                    <div class="card-header d-flex justify-content-between align-items-center bg-primary">
                        <h5 class="mb-0 text-white">Edit Farm</h5>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-light btn-sm">
                                <i class="material-icons-outlined">save</i> Update
                            </button>
                            <a href="{{ route('farms.show', $farm->id) }}" class="btn btn-light btn-sm">
                                <i class="material-icons-outlined">cancel</i> Cancel
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Farm Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $farm->name) }}"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Owner Name</label>
                                <input type="text" name="owner_name" value="{{ old('owner_name', $farm->owner_name) }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone', $farm->phone) }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email', $farm->email) }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City</label>
                                <input type="text" name="city" value="{{ old('city', $farm->city) }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">State</label>
                                <input type="text" name="state" value="{{ old('state', $farm->state) }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" value="{{ old('country', $farm->country) }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Zipcode</label>
                                <input type="text" name="zipcode" value="{{ old('zipcode', $farm->zipcode) }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Area</label>
                                <input type="text" name="area" value="{{ old('area', $farm->area) }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Registration Number</label>
                                <input type="text" name="registration_number"
                                    value="{{ old('registration_number', $farm->registration_number) }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Established At</label>
                                <input type="date" name="established_at"
                                    value="{{ old('established_at', $farm->established_at ? \Carbon\Carbon::parse($farm->established_at)->format('Y-m-d') : '') }}"
                                    class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description', $farm->description) }}</textarea>
                            </div>

                            @if (auth()->user()->isSuperAdmin())
                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="1" {{ old('status', $farm->status) == 1 ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="0" {{ old('status', $farm->status) == 0 ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="status" value="{{ $farm->status }}">
                            @endif

                            <div class="col-md-12">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="2">{{ old('notes', $farm->notes) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Buttons -->
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="material-icons-outlined">save</i> Update
                        </button>
                        <a href="{{ route('farms.show', $farm->id) }}" class="btn btn-secondary px-4">
                            <i class="material-icons-outlined">cancel</i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
