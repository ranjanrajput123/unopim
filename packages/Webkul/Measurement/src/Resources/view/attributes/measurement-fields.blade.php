<div v-if="selectedAttributeType == 'measurement'">

    <!-- Measurement Family -->
    <x-admin::form.control-group>
        <x-admin::form.control-group.label>
            Measurement Family
        </x-admin::form.control-group.label>

        <select class="w-full py-2 px-3 border rounded"
            name="measurement_family"
            v-model="selectedMeasurementFamily">
            <option value="">Select family</option>

            @foreach ($families as $f)
            <option value="{{ $f['code'] }}">{{ $f['name'] }}</option>
            @endforeach
        </select>
    </x-admin::form.control-group>

    <!-- Measurement Unit -->
    <x-admin::form.control-group>
        <x-admin::form.control-group.label>
            Measurement Unit
        </x-admin::form.control-group.label>

        <select class="w-full py-2 px-3 border rounded"
            name="measurement_unit"
            v-model="selectedMeasurementUnit">
            <option value="">Select unit</option>

            <option v-for="unit in measurementUnits"
                :key="unit.code"
                :value="unit.code">
                @{{ unit.labels?.en_US ?? unit.code }}
            </option>
        </select>
    </x-admin::form.control-group>

</div>


@pushOnce('scripts')
<script type="module">
    app.component('v-admin-catalog-attributes-edit', {
        data() {
            return {
                families: @json($families),

                selectedMeasurementFamily: "{{ $attribute->measurement_family }}",
                selectedMeasurementUnit: "{{ $attribute->measurement_unit }}",

                measurementUnits: [],
            };
        },

        watch: {
            selectedMeasurementFamily(newVal) {
                const family = this.families.find(f => f.code === newVal);
                this.measurementUnits = family ? family.units : [];

                // Reset invalid unit
                if (!this.measurementUnits.some(u => u.code === this.selectedMeasurementUnit)) {
                    this.selectedMeasurementUnit = "";
                }
            }
        },

        mounted() {
            const family = this.families.find(f => f.code === this.selectedMeasurementFamily);
            this.measurementUnits = family ? family.units : [];
        }
    });
</script>
@endpushOnce