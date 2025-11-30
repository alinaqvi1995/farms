@extends('dashboard.includes.partial.base')

@section('title', 'Animals')

@section('content')
    <h6 class="mb-0 text-uppercase">Animals</h6>
    <hr>

    @can('create-animals')
        <div class="mb-3 text-end">
            <button class="btn btn-grd btn-grd-primary" id="addAnimalBtn">
                <i class="material-icons-outlined">add</i> Add Animal
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
                            <th>Tag #</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Breed</th>
                            <th>Farm</th>
                            <th>Gender</th>
                            <th>Birth Date</th>
                            <th>Health</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($animals as $animal)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('animals.show', $animal->id) }}">
                                        {{ $animal->tag_number }}
                                    </a>
                                </td>
                                <td>{{ $animal->name ?? '-' }}</td>
                                <td>{{ $animal->type ?? '-' }}</td>
                                <td>{{ $animal->breed ?? '-' }}</td>
                                <td>{{ $animal->farm->name ?? '-' }}</td>
                                <td>{{ $animal->gender ?? '-' }}</td>
                                <td>{{ $animal->birth_date ?? '-' }}</td>
                                <td>{{ $animal->health_status ?? '-' }}</td>
                                <td>{!! $animal->status_label ?? '-' !!}</td>
                                <td>
                                    @can('edit-animals')
                                        <button class="btn btn-sm btn-info editAnimalBtn" data-id="{{ $animal->id }}"
                                            data-farm="{{ $animal->farm_id }}" data-tag="{{ $animal->tag_number }}"
                                            data-name="{{ $animal->name }}" data-type="{{ $animal->type }}"
                                            data-breed="{{ $animal->breed }}" data-birth="{{ $animal->birth_date }}"
                                            data-gender="{{ $animal->gender }}" data-color="{{ $animal->color }}"
                                            data-source="{{ $animal->source }}" data-price="{{ $animal->purchase_price }}"
                                            data-purchase_date="{{ $animal->purchase_date }}"
                                            data-vendor="{{ $animal->vendor }}" data-health="{{ $animal->health_status }}"
                                            data-city="{{ $animal->city }}" data-state="{{ $animal->state }}"
                                            data-area="{{ $animal->area }}" data-notes="{{ $animal->notes }}"
                                            data-status="{{ $animal->status }}">
                                            <i class="material-icons-outlined">edit</i>
                                        </button>
                                    @endcan
                                    @can('delete-animals')
                                        <form action="{{ route('animals.destroy', $animal->id) }}" method="POST"
                                            class="d-inline">
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
