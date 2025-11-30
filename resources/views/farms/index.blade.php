@extends('dashboard.includes.partial.base')

@section('title', 'Farms')

@section('content')
    <h6 class="mb-0 text-uppercase">Farms</h6>
    <hr>

    @can('create-farms')
        <div class="mb-3 text-end">
            <button class="btn btn-grd btn-grd-primary" id="addFarmBtn">
                <i class="material-icons-outlined">add</i> Add Farm
            </button>
        </div>
    @endcan

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle datatable">
                    <thead>
                        <tr>
                            <th>Sr#.</th>
                            <th>Name</th>
                            <th>Owner</th>
                            <th>Users</th>
                            <th>Animals</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Modified By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($farms as $farm)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('farms.show', $farm->id) }}">
                                        {{ $farm->name }}
                                    </a>
                                </td>
                                <td>{{ $farm->owner_name ?? '-' }}</td>
                                <td>{{ $farm->users()->count() }}</td>
                                <td>{{ $farm->animals()->count() }}</td>
                                <td>{!! $farm->status_label ?? '-' !!}</td>
                                <td>{{ $farm->creator_name ?? '-' }}</td>
                                <td>{{ $farm->editor_name ?? '-' }}</td>
                                <td>
                                    @can('edit-farms')
                                        <button class="btn btn-sm btn-info editFarmBtn" data-id="{{ $farm->id }}"
                                            data-name="{{ $farm->name }}" data-owner="{{ $farm->owner_name }}"
                                            data-phone="{{ $farm->phone }}" data-email="{{ $farm->email }}"
                                            data-address="{{ $farm->address }}" data-city="{{ $farm->city }}"
                                            data-state="{{ $farm->state }}" data-country="{{ $farm->country }}"
                                            data-zipcode="{{ $farm->zipcode }}" data-area="{{ $farm->area }}"
                                            data-description="{{ $farm->description }}" data-status="{{ $farm->status }}">
                                            <i class="material-icons-outlined">edit</i>
                                        </button>
                                    @endcan
                                    @can('delete-farms')
                                        <form action="{{ route('farms.destroy', $farm->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="material-icons-outlined">delete</i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
    {{-- Optional JS for modal or datatable --}}
@endsection
