<div class="col-12">
    <div class="card mb-3">
        <div class="card-header bg-info d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">Vaccinations</h5>
            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#vaccinationModal">
                <i class="material-icons-outlined">add</i> Add Vaccine
            </button>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($animal->vaccinations as $vac)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $vac->vaccine_name }} - {{ \Carbon\Carbon::parse($vac->date_given)->format('d M, Y H:i') }}
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#vaccinationModal" data-id="{{ $vac->id }}">
                            Edit
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
