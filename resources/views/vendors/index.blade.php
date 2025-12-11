@extends('dashboard.includes.partial.base')

@section('title', 'Vendors')

@section('content')
    <h6 class="mb-0 text-uppercase">Vendors</h6>
    <hr>

    <div class="mb-3 text-end">
        <button class="btn btn-grd btn-grd-primary" id="addVendorBtn">
            <i class="material-icons-outlined">add</i> Add Vendor
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle datatable">
                    <thead>
                        <tr>
                            <th>Sr#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            @if (auth()->user()->isSuperAdmin())
                                <th>Farms</th>
                            @endif
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendors as $vendor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $vendor->name }}</td>
                                <td>{{ $vendor->phone }}</td>
                                <td>{{ $vendor->address ?? '-' }}</td>
                                @if (auth()->user()->isSuperAdmin())
                                    <td>
                                        @foreach ($vendor->farms as $farm)
                                            <span class="badge bg-secondary">{{ $farm->name }}</span>
                                        @endforeach
                                    </td>
                                @endif
                                <td>
                                    <button class="btn btn-sm btn-info editVendorBtn" data-id="{{ $vendor->id }}"
                                        data-name="{{ $vendor->name }}" data-phone="{{ $vendor->phone }}"
                                        data-address="{{ $vendor->address }}">
                                        <i class="material-icons-outlined">edit</i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ADD VENDOR MODAL -->
    <div class="modal fade" id="addVendorModal" tabindex="-1">
        <div class="modal-dialog modal-md">
            <form action="{{ route('vendors.store') }}" method="POST" class="modal-content">
                @csrf

                @if (auth()->user()->isFarmAdmin() && auth()->user()->farm)
                    <input type="hidden" name="farm_id" value="{{ auth()->user()->farm->id }}">
                @endif

                <div class="modal-header">
                    <h5 class="modal-title">Add Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @if (auth()->user()->isSuperAdmin())
                        <div class="mb-3">
                            <label class="form-label">Select Farm</label>
                            <select name="farm_id" class="form-control" required>
                                <option value="">-- Select Farm --</option>
                                @foreach (\App\Models\Farm::all() as $f)
                                    <option value="{{ $f->id }}">{{ $f->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                        <small class="text-muted">If name matches existing vendor, it will be associated.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                        <small class="text-muted">Unique identifier for vendors.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save Vendor</button>
                </div>
            </form>
        </div>
    </div>

    <!-- EDIT VENDOR MODAL -->
    <div class="modal fade" id="editVendorModal" tabindex="-1">
        <div class="modal-dialog modal-md">
            <form method="POST" class="modal-content" id="editVendorForm">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="edit_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" id="edit_phone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" id="edit_address" rows="2"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Update Vendor</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('extra_js')
    <script>
        document.getElementById('addVendorBtn').addEventListener('click', function() {
            new bootstrap.Modal(document.getElementById('addVendorModal')).show();
        });

        document.querySelectorAll('.editVendorBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.dataset.id;
                let name = this.dataset.name;
                let phone = this.dataset.phone;
                let address = this.dataset.address;

                document.getElementById('edit_name').value = name;
                document.getElementById('edit_phone').value = phone;
                document.getElementById('edit_address').value = address;

                document.getElementById('editVendorForm').action = `/vendors/${id}`;

                new bootstrap.Modal(document.getElementById('editVendorModal')).show();
            });
        });
    </script>
@endsection
