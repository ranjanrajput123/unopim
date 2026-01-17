<x-admin::layouts.with-history>
    <x-slot:entityName>
        measurement_unit
    </x-slot:entityName>

    <x-slot:title>
        Edit Unit - {{ $unit['code'] }}
    </x-slot:title>

    <x-admin::form
        method="PUT"
        action="{{ route('admin.measurement.families.units.update', [
            'familyid' => $family->id,
            'code'      => $unit['code']
        ]) }}">

        <!-- PAGE HEADER -->
        <div class="grid gap-2.5 mb-4">
            <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">

                <p class="text-xl text-gray-800 dark:text-slate-50 font-bold leading-6">
                    Edit Unit | {{ $unit['code'] }}
                </p>

                <div class="flex gap-x-2.5 items-center">

                    <!-- BACK BUTTON -->
                    <a
                        href="{{ route('admin.measurement.families.edit', $family->id) }}"
                        class="transparent-button">
                        Back
                    </a>

                    <!-- SAVE BUTTON -->
                    <button class="primary-button">
                        Save
                    </button>

                </div>
            </div>
        </div>

        <!-- FORM BODY -->
        <div class="relative p-4 bg-white dark:bg-cherry-900 rounded box-shadow">

            <p class="text-base text-gray-800 dark:text-white font-semibold mb-4">
                Unit Information
            </p>

            {{-- Code (View only) --}}
            <x-admin::form.control-group>
                <x-admin::form.control-group.label>
                    Code
                </x-admin::form.control-group.label>

                <x-admin::form.control-group.control
                    type="text"
                    name="code"
                    value="{{ $unit['code'] }}"
                    disabled />
            </x-admin::form.control-group>


            {{-- Symbol --}}
            <x-admin::form.control-group>
                <x-admin::form.control-group.label class="required">
                    Symbol
                </x-admin::form.control-group.label>

                <x-admin::form.control-group.control
                    type="text"
                    name="symbol"
                    value="{{ old('symbol', $unit['symbol'] ?? '') }}"
                    rules="required"
                    placeholder="Enter unit symbol" />

                <x-admin::form.control-group.error control-name="symbol" />
            </x-admin::form.control-group>


            {{-- Label Translations --}}
            <p class="text-base text-gray-800 dark:text-white font-semibold mt-6 mb-2">
                Label translations in UI locale
            </p>

            {{-- English --}}
            <x-admin::form.control-group>
                <x-admin::form.control-group.label>
                    English (en_US)
                </x-admin::form.control-group.label>

                <x-admin::form.control-group.control
                    type="text"
                    name="labels[en_US]"
                    value="{{ old('labels.en_US', $unit['labels']['en_US'] ?? '') }}"
                    placeholder="Enter English label" />
            </x-admin::form.control-group>

            {{-- Catalan --}}
            <x-admin::form.control-group>
                <x-admin::form.control-group.label>
                    Catalan (es_CA)
                </x-admin::form.control-group.label>

                <x-admin::form.control-group.control
                    type="text"
                    name="labels[es_CA]"
                    value="{{ old('labels.es_CA', $unit['labels']['es_CA'] ?? '') }}"
                    placeholder="Enter Catalan label" />
            </x-admin::form.control-group>

            {{-- German --}}
            <x-admin::form.control-group>
                <x-admin::form.control-group.label>
                    German (de_DE)
                </x-admin::form.control-group.label>

                <x-admin::form.control-group.control
                    type="text"
                    name="labels[de_DE]"
                    value="{{ old('labels.de_DE', $unit['labels']['de_DE'] ?? '') }}"
                    placeholder="Enter German label" />
            </x-admin::form.control-group>

            {{-- Spanish --}}
            <x-admin::form.control-group>
                <x-admin::form.control-group.label>
                    Spanish (es_ES)
                </x-admin::form.control-group.label>

                <x-admin::form.control-group.control
                    type="text"
                    name="labels[es_ES]"
                    value="{{ old('labels.es_ES', $unit['labels']['es_ES'] ?? '') }}"
                    placeholder="Enter Spanish label" />
            </x-admin::form.control-group>

        </div>

    </x-admin::form>

</x-admin::layouts.with-history>