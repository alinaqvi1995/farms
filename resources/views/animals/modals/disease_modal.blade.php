<div class="modal fade" id="diseaseModal" tabindex="-1" aria-labelledby="diseaseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('diseases.store') }}" id="diseaseForm">
            @csrf
            <input type="hidden" name="animal_id" value="{{ $animal->id }}">
            <input type="hidden" name="farm_id" value="{{ $animal->farm_id }}">
            <input type="hidden" name="id" id="disease_id">

            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="diseaseModalLabel">Add/Edit Disease</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Disease Name</label>
                        <input type="text" name="disease_name" id="disease_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Diagnosed Date</label>
                        <input type="date" name="diagnosed_date" id="disease_diagnosed_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Recovered Date</label>
                        <input type="date" name="recovered_date" id="disease_recovered_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="disease_status" class="form-select">
                            <option value="sick">Sick</option>
                            <option value="recovering">Recovering</option>
                            <option value="recovered">Recovered</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Symptoms</label>
                        <textarea name="symptoms" id="disease_symptoms" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" id="disease_notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Save</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
