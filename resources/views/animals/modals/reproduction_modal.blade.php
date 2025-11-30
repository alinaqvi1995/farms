<div class="modal fade" id="reproductionModal" tabindex="-1" aria-labelledby="reproductionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('reproductions.store') }}" id="reproductionForm">
            @csrf
            <input type="hidden" name="animal_id" value="{{ $animal->id }}">
            <input type="hidden" name="farm_id" value="{{ $animal->farm_id }}">
            <input type="hidden" name="id" id="reproduction_id">

            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="reproductionModalLabel">Add/Edit Reproduction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" id="rep_type" class="form-select" required>
                            <option value="heat">Heat</option>
                            <option value="mating">Mating</option>
                            <option value="ai">AI</option>
                            <option value="pregnancy_check">Pregnancy Check</option>
                            <option value="calving">Calving</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Event Date</label>
                        <input type="date" name="event_date" id="rep_event_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" id="rep_notes" class="form-control" rows="2"></textarea>
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
