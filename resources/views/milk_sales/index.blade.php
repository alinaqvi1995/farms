@extends('dashboard.includes.partial.base')

@section('title', 'Milk Sales')

@section('content')
    <h6 class="mb-0 text-uppercase">Milk Sales</h6>
    <hr>

    <div class="mb-3 text-end">
        <button class="btn btn-grd btn-grd-primary" id="addSaleBtn">
            <i class="material-icons-outlined">add</i> Record Sale
        </button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <h6 class="mb-2">Today's Production</h6>
                    <h3 class="mb-0">{{ number_format($todayProductionTotal, 2) }} L</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <h6 class="mb-2">Today's Sales</h6>
                    <h3 class="mb-0">{{ number_format($todaySalesTotal, 2) }} L</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card {{ $remainingStock < 0 ? 'bg-danger' : 'bg-warning text-dark' }} h-100">
                <div class="card-body">
                    <h6 class="mb-2">Remaining Stock</h6>
                    <h3 class="mb-0">{{ number_format($remainingStock, 2) }} L</h3>
                    @if ($remainingStock < 0)
                        <small class="text-white-50"><i class="material-icons-outlined fs-6 align-middle">warning</i>
                            Oversold!</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle datatable">
                    <thead>
                        <tr>
                            <th>Sr#</th>
                            <th>Date</th>
                            <th>Vendor</th>
                            <th>Quantity (L)</th>
                            <th>Type</th>
                            <th>Price/Unit</th>
                            <th>Total</th>
                            @if (auth()->user()->isSuperAdmin())
                                <th>Farm</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sale->sold_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $sale->vendor->name }}</td>
                                <td>{{ $sale->quantity }}</td>
                                <td>
                                    @if ($sale->price_type === 'admin')
                                        <span class="badge bg-primary">Admin</span>
                                    @else
                                        <span class="badge bg-info">Custom</span>
                                    @endif
                                </td>
                                <td>{{ $sale->price_per_unit }}</td>
                                <td>{{ $sale->total_amount }}</td>
                                @if (auth()->user()->isSuperAdmin())
                                    <td>{{ $sale->farm->name }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ADD SALE MODAL -->
    <div class="modal fade" id="addSaleModal" tabindex="-1">
        <div class="modal-dialog modal-md">
            <form action="{{ route('milk_sales.store') }}" method="POST" class="modal-content">
                @csrf

                @if (auth()->user()->isFarmAdmin() && auth()->user()->farm)
                    <input type="hidden" name="farm_id" value="{{ auth()->user()->farm->id }}">
                @endif

                <div class="modal-header">
                    <h5 class="modal-title">Record Milk Sale</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @if (auth()->user()->isSuperAdmin())
                        <div class="mb-3">
                            <label class="form-label">Select Farm</label>
                            <select name="farm_id" class="form-control" required>
                                <option value="">-- Select Farm --</option>
                                @foreach ($farms as $f)
                                    <option value="{{ $f->id }}">{{ $f->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Vendor</label>
                        <div class="d-flex gap-2">
                            <select name="vendor_id" class="form-control" required>
                                <option value="">-- Select Vendor --</option>
                                @foreach ($vendors as $v)
                                    <option value="{{ $v->id }}">{{ $v->name }} ({{ $v->phone }})
                                    </option>
                                @endforeach
                            </select>
                            <a href="{{ route('vendors.index') }}" class="btn btn-outline-secondary"
                                title="Add New Vendor"><i class="material-icons-outlined">add</i></a>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="quantity" class="form-control" required>
                            <span class="input-group-text">Liters</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pricing Type</label>
                        <select name="price_type" class="form-control" id="priceTypeSelector" required>
                            <option value="admin">Admin Price</option>
                            <option value="custom">Custom Price</option>
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="customPriceDiv">
                        <label class="form-label">Custom Price per Unit</label>
                        <input type="number" step="0.01" name="custom_price" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date Sold</label>
                        <input type="datetime-local" name="sold_at" class="form-control"
                            value="{{ now()->format('Y-m-d\TH:i') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save Sale</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('extra_js')
    <script>
        document.getElementById('addSaleBtn').addEventListener('click', function() {
            new bootstrap.Modal(document.getElementById('addSaleModal')).show();
        });

        document.getElementById('priceTypeSelector').addEventListener('change', function() {
            if (this.value === 'custom') {
                document.getElementById('customPriceDiv').classList.remove('d-none');
            } else {
                document.getElementById('customPriceDiv').classList.add('d-none');
            }
        });
    </script>
@endsection
