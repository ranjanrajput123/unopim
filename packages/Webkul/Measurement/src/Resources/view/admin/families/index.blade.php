<x-admin::layouts>
    <x-slot:title>
        {{ __('Measurement Families') }}
        </x-slot>

        <!-- Page Header -->
        <div class="flex gap-4 justify-between items-center max-sm:flex-wrap mb-4">
            <p class="text-xl text-gray-800 dark:text-white font-bold">
                {{ __('Measurement') }}
            </p>

            <div class="flex gap-x-2.5 items-center">
                <v-create-family-form />
            </div>
        </div>

        <!-- Datagrid -->


        <x-admin::datagrid ref="datagrid" src="{{ route('admin.measurement.families.index') }}">
        </x-admin::datagrid>


        <!-- Create Family Modal -->
        @pushOnce('scripts')
        <script type="text/x-template" id="v-create-family-form-template">
            <div>
                <button
                    type="button"
                    class="primary-button"
                    @click="$refs.familyCreateModal.toggle()"
                >
                    {{ __('Create Measurement Family') }}
                </button>

                <!-- Modal -->
                <x-admin::modal ref="familyCreateModal">
                    <x-slot:header>
                        <h2 class="text-lg font-bold">{{ __('Create Measurement family') }}</h2>
                    </x-slot:header>

                    <x-slot:content>
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                {{ __('Code') }}
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="code"
                                v-model="form.code"
                                rules="required"
                                placeholder="{{ __('Enter family code') }}"
                            />

                            <x-admin::form.control-group.error control-name="code" />
                        </x-admin::form.control-group>

                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label>
                                {{ __('Label') }}
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="label"
                                v-model="form.label"
                                placeholder="{{ __('Enter family label') }}"
                            />
                        </x-admin::form.control-group>

                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                {{ __('Standard Unit Code') }}
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="standard_unit_code"
                                v-model="form.standard_unit_code"
                                rules="required"
                                placeholder="{{ __('Enter standard unit code') }}"
                            />
                        </x-admin::form.control-group>

                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label>
                                {{ __('Standard Unit Label') }}
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="standard_unit_label"
                                v-model="form.standard_unit_label"
                                placeholder="{{ __('Enter standard unit label') }}"
                            />
                        </x-admin::form.control-group>

                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label>
                                {{ __('Symbol') }}
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="symbol"
                                v-model="form.symbol"
                                placeholder="{{ __('e.g. km, m') }}"
                            />
                        </x-admin::form.control-group>
                    </x-slot:content>


                    <x-slot:footer>
                        <button
                            type="button"
                            class="primary-button"
                            @click="save"
                        >
                            {{ __('Save') }}
                        </button>
                    </x-slot:footer>
                </x-admin::modal>
            </div>
        </script>

        <script type="module">
            app.component('v-create-family-form', {
                template: '#v-create-family-form-template',

                data() {
                    return {
                        form: {
                            name: '',
                            standard_unit: '',
                        }
                    };
                },

                methods: {
                    save() {

                        axios.post(
                                "{{ route('admin.measurement.families.store') }}",
                                this.form
                            )
                            .then(res => {
                                this.$refs.familyCreateModal.close();


                                this.form.name = '';
                                this.form.standard_unit = '';

                                if (res.data?.data?.redirect_url) {
                                    window.location.href = res.data.data.redirect_url;
                                }
                            })
                            .catch(err => {
                                console.error(err);
                            });
                    }
                }
            });
        </script>
        @endPushOnce
</x-admin::layouts>