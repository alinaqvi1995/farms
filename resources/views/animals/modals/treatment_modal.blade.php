<div class="modal fade" id="treatmentModal" tabindex="-1" aria-labelledby="treatmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('treatments.store') }}" id="treatmentForm">
            @csrf
            <input type="hidden" name="animal_id" value="{{ $animal->id }}">
            <input type="hidden" name="farm_id" value="{{ $animal->farm_id }}">
            <input type="hidden" name="id" id="treatment_id">

            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="treatmentModalLabel">Add/Edit Treatment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Treatment Type</label>
                        <input type="text" name="treatment_type" id="treatment_type" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Treatment Date</label>
                        <input type="date" name="treatment_date" id="treatment_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Given By</label>
                        <input type="text" name="given_by" id="treatment_given_by" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Medicine</label>
                        <input type="text" name="medicine" id="treatment_medicine" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dosage</label>
                        <input type="text" name="dosage" id="treatment_dosage" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Duration</label>
                        <input type="text" name="duration" id="treatment_duration" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" id="treatment_notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary">Save</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
