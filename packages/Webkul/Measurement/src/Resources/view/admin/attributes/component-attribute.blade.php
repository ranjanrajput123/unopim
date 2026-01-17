@php
    $fieldLabel = $field->translate(
        core()->getRequestedLocaleCode()
    )['name'] ?? '[' . $field->code . ']';

    $measurementValue = is_array($value) ? ($value['value'] ?? '') : '';
    $measurementUnit  = is_array($value) ? ($value['unit'] ?? '') : '';
@endphp

<div class="grid gap-4 grid-cols-[repeat(auto-fit,minmax(200px,1fr))]">

    <!-- Value -->
    <x-admin::form.control-group.control
        type="text"
        :label="$fieldLabel"
        name="{{ $fieldName }}[value]"
        :value="$measurementValue"
        placeholder="Enter value"
    />

    <!-- Unit -->
    <x-admin::form.control-group.control
        type="select"
        label="Unit"
        name="{{ $fieldName }}[unit]"
    >
        <option value="">Select Unit</option>
        <option value="cm" @selected($measurementUnit === 'cm')>cm</option>
        <option value="m"  @selected($measurementUnit === 'm')>m</option>
        <option value="kg" @selected($measurementUnit === 'kg')>kg</option>
        <option value="g"  @selected($measurementUnit === 'g')>g</option>
    </x-admin::form.control-group.control>

</div>
