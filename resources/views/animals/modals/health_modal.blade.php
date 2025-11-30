<div class="modal fade" id="healthModal" tabindex="-1" aria-labelledby="healthModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('health_checks.store') }}" id="healthForm">
            @csrf
            <input type="hidden" name="animal_id" value="{{ $animal->id }}">
            <input type="hidden" name="farm_id" value="{{ $animal->farm_id }}">
            <input type="hidden" name="id" id="health_id">

            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="healthModalLabel">Add/Edit Health Check</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Check Date</label>
                        <input type="date" name="check_date" id="health_check_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Overall Condition</label>
                        <input type="text" name="overall_condition" id="health_overall_condition" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Temperature</label>
                        <input type="text" name="body_temperature" id="health_body_temperature" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Heart Rate</label>
                        <input type="text" name="heart_rate" id="health_heart_rate" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Respiration Rate</label>
                        <input type="text" name="respiration_rate" id="health_respiration_rate" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Checked By</label>
                        <input type="text" name="checked_by" id="health_checked_by" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" id="health_notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
