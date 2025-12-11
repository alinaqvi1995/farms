@extends('dashboard.includes.partial.base')

@section('title', 'Global Settings')

@section('content')
    <h6 class="mb-0 text-uppercase">Global Settings</h6>
    <hr>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Pricing Configuration</h5>
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Default Milk Price (per Liter)</label>
                            <div class="input-group">
                                <span class="input-group-text">PKR</span>
                                <input type="number" step="0.01" name="milk_default_price" class="form-control"
                                    value="{{ $milkPrice ?? '0' }}" required>
                            </div>
                            <small class="text-muted">This price is used when "Admin Price" is selected during a milk
                                sale.</small>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
        </div>
    </div>
@endsection
