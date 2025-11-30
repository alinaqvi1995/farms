<div class="col-12">
    <div class="card mb-3">
        <div class="card-header bg-info d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">Reproductions</h5>
            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#reproductionModal">
                <i class="material-icons-outlined">add</i> Add Reproduction
            </button>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($animal->reproductions as $rep)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ ucfirst($rep->type) }} on {{ \Carbon\Carbon::parse($rep->event_date)->format('d M, Y H:i') }}
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#reproductionModal" data-id="{{ $rep->id }}">
                            Edit
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
