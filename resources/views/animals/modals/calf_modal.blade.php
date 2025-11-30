<div class="modal fade" id="calfModal" tabindex="-1" aria-labelledby="calfModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('calves.store') }}" id="calfForm">
            @csrf
            <input type="hidden" name="mother_id" value="{{ $animal->id }}">
            <input type="hidden" name="animal_id" value="{{ $animal->id }}">
            <input type="hidden" name="farm_id" value="{{ $animal->farm_id }}">
            <input type="hidden" name="id" id="calf_id">

            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="calfModalLabel">Add/Edit Calf</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tag Number</label>
                        <input type="text" name="tag_number" id="calf_tag_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" id="calf_gender" class="form-select" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Birth Date</label>
                        <input type="date" name="birth_date" id="calf_birth_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Birth Weight (kg)</label>
                        <input type="number" step="0.01" name="birth_weight" id="calf_birth_weight" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Current Weight (kg)</label>
                        <input type="number" step="0.01" name="current_weight" id="calf_current_weight" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Weaning Date</label>
                        <input type="date" name="weaning_date" id="calf_weaning_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" id="calf_notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
