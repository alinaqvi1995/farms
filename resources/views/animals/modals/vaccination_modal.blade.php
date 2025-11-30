<div class="modal fade" id="vaccinationModal" tabindex="-1" aria-labelledby="vaccinationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('vaccinations.store') }}" id="vaccinationForm">
            @csrf
            <input type="hidden" name="animal_id" value="{{ $animal->id }}">
            <input type="hidden" name="farm_id" value="{{ $animal->farm_id }}">
            <input type="hidden" name="id" id="vaccination_id">

            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="vaccinationModalLabel">Add/Edit Vaccination</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Vaccine Name</label>
                        <input type="text" name="vaccine_name" id="vaccination_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date Given</label>
                        <input type="date" name="date_given" id="vaccination_date_given" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Next Due Date</label>
                        <input type="date" name="next_due_date" id="vaccination_next_due_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dose</label>
                        <input type="text" name="dose" id="vaccination_dose" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Administered By</label>
                        <input type="text" name="administered_by" id="vaccination_administered_by" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" id="vaccination_notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
