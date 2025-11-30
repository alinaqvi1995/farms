<div class="col-12">
    <div class="card mb-3">
        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">Diseases</h5>
            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#diseaseModal">
                <i class="material-icons-outlined">add</i> Add Disease
            </button>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($animal->diseases as $disease)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $disease->disease_name }} - {{ $disease->status }}
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#diseaseModal" data-id="{{ $disease->id }}">
                            Edit
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
