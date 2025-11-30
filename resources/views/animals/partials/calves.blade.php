<div class="col-12">
    <div class="card mb-3">
        <div class="card-header bg-warning d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">Calves</h5>
            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#calfModal">
                <i class="material-icons-outlined">add</i> Add Calf
            </button>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($animal->calves as $calf)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $calf->tag_number }} ({{ ucfirst($calf->gender) }}) - {{ \Carbon\Carbon::parse($calf->birth_date)->format('d M, Y H:i') }}
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#calfModal" data-id="{{ $calf->id }}">
                            Edit
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
