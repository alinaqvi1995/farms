<div class="modal fade" id="milkModal" tabindex="-1" aria-labelledby="milkModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('milk_productions.store') }}" id="milkForm">
            @csrf
            <input type="hidden" name="animal_id" value="{{ $animal->id }}">
            <input type="hidden" name="farm_id" value="{{ $animal->farm_id }}">
            <input type="hidden" name="id" id="milk_id">

            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="milkModalLabel">Add/Edit Milk Production</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Session</label>
                        <select name="session" id="milk_session" class="form-select" required>
                            <option value="morning">Morning</option>
                            <option value="afternoon">Afternoon</option>
                            <option value="evening">Evening</option>
                            <option value="night">Night</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Litres</label>
                        <input type="number" step="0.01" name="litres" id="milk_litres" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Recorded At</label>
                        <input type="datetime-local" name="recorded_at" id="milk_recorded_at" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" id="milk_notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const milkModal = document.getElementById('milkModal');
    milkModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const milkId = button.getAttribute('data-id');

        if(milkId) {
            fetch(`/milk_productions/${milkId}/edit`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('milk_id').value = data.id;
                    document.getElementById('milk_session').value = data.session;
                    document.getElementById('milk_litres').value = data.litres;
                    document.getElementById('milk_recorded_at').value = data.recorded_at.replace(' ', 'T');
                    document.getElementById('milk_notes').value = data.notes;
                });
        } else {
            document.getElementById('milkForm').reset();
            document.getElementById('milk_id').value = '';
        }
    });
</script>
