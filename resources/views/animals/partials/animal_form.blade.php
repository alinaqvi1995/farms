<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Name <span class="text-danger">*</span></label>
        <input type="text" name="name" value="{{ old('name', $animal->name ?? '') }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Tag Number</label>
        <input type="text" name="tag_number" value="{{ old('tag_number', $animal->tag_number ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Type</label>
        <input type="text" name="type" value="{{ old('type', $animal->type ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Breed</label>
        <input type="text" name="breed" value="{{ old('breed', $animal->breed ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select">
            <option value="">Select Gender</option>
            <option value="male" {{ old('gender', $animal->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('gender', $animal->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Color</label>
        <input type="text" name="color" value="{{ old('color', $animal->color ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Birth Date</label>
        <input type="date" name="birth_date" value="{{ old('birth_date', isset($animal->birth_date) ? \Carbon\Carbon::parse($animal->birth_date)->format('Y-m-d') : '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Source</label>
        <input type="text" name="source" value="{{ old('source', $animal->source ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Purchase Price</label>
        <input type="number" step="0.01" name="purchase_price" value="{{ old('purchase_price', $animal->purchase_price ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Purchase Date</label>
        <input type="date" name="purchase_date" value="{{ old('purchase_date', isset($animal->purchase_date) ? \Carbon\Carbon::parse($animal->purchase_date)->format('Y-m-d') : '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Vendor</label>
        <input type="text" name="vendor" value="{{ old('vendor', $animal->vendor ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">City</label>
        <input type="text" name="city" value="{{ old('city', $animal->city ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">State</label>
        <input type="text" name="state" value="{{ old('state', $animal->state ?? '') }}" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Area</label>
        <input type="text" name="area" value="{{ old('area', $animal->area ?? '') }}" class="form-control">
    </div>

    <div class="col-md-12">
        <label class="form-label">Health Status</label>
        <input type="text" name="health_status" value="{{ old('health_status', $animal->health_status ?? '') }}" class="form-control">
    </div>

    <div class="col-md-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="2">{{ old('notes', $animal->notes ?? '') }}</textarea>
    </div>
</div>
