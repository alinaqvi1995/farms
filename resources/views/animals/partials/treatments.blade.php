<div class="col-12">
    <div class="card mb-3">
        <div class="card-header bg-secondary d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">Treatments</h5>
            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#treatmentModal">
                <i class="material-icons-outlined">add</i> Add Treatment
            </button>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($animal->treatments as $treat)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $treat->treatment_type }} - {{ \Carbon\Carbon::parse($treat->treatment_date)->format('d M, Y H:i') }}
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#treatmentModal" data-id="{{ $treat->id }}">
                            Edit
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
