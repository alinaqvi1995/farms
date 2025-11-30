<div class="col-12">
    <div class="card mb-3">
        <div class="card-header bg-success d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">Milk Productions</h5>
            <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#milkModal">
                <i class="material-icons-outlined">add</i> Add Milk
            </button>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($animal->milkProductions as $milk)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ ucfirst($milk->session) }} - {{ $milk->litres }} L ({{ \Carbon\Carbon::parse($milk->recorded_at)->format('d M, Y H:i') }})
                        {{-- <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#milkModal" data-id="{{ $milk->id }}">
                            Edit
                        </button> --}}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
