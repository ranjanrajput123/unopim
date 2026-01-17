<?php
// I will begin preparing the full Measurement Attribute Type integration here.
// Once you provide more specific structure or files, I will continue expanding this.

// resources/view/admin/catalog/attributes/extra-fields.blade.php
?>
<div class="mt-4" id="measurement-attribute-fields">
    <div class="form-group">
        <label>Measurement Family</label>
        <select name="measurement_family" id="measurement_family" class="form-control">
            <option value="">-- Select Family --</option>
            @foreach ($measurementFamilies as $family)
            <option value="{{ $family->code }}" {{ (isset($attribute) && $attribute->measurement_family == $family->code) ? 'selected' : '' }}>
                {{ $family->name }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mt-3">
        <label>Default Unit</label>
        <select name="default_unit" id="default_unit" class="form-control">
            @if(isset($attribute) && $attribute->default_unit)
            <option value="{{ $attribute->default_unit }}" selected>{{ $attribute->default_unit }}</option>
            @else
            <option value="">-- Select Unit --</option>
            @endif
        </select>
    </div>
</div>

<script>
    document.getElementById('measurement_family').addEventListener('change', function() {
        let family = this.value;

        fetch(`/admin/measurement/families/units?family=${family}`)
            .then(res => res.json())
            .then(data => {
                let unitSelect = document.getElementById('default_unit');
                unitSelect.innerHTML = '';
                data.forEach(unit => {
                    let opt = document.createElement('option');
                    opt.value = unit.code;
                    opt.textContent = unit.symbol ? `${unit.code} (${unit.symbol})` : unit.code;
                    unitSelect.appendChild(opt);
                });
            });
    });
</script>