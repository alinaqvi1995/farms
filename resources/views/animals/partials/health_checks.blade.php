<div class="col-12">
    <div class="card mb-3">
        <div class="card-header bg-danger d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">Health Checks</h5>
            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#healthModal">
                <i class="material-icons-outlined">add</i> Add Check
            </button>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($animal->healthChecks as $check)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $check->check_date->format('d M, Y') }} - {{ $check->overall_condition ?? '-' }}
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#healthModal" data-id="{{ $check->id }}">
                            Edit
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
