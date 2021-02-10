<template>
    <v-modal ref="modal">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="p-6">
                <h3 class="font-medium text-lg">{{ $trans('headings.edit-team-member') }}</h3>
            </div>

            <div class="p-6">
                <div class="form-group mb-6">
                    <label class="form-label">{{ $trans('labels.name') }}</label>
                    <input class="form-input" v-model="form.name">
                    <span class="invalid-feedback" v-if="$page.errors.has('name')">{{ $page.errors.first('name') }}</span>
                </div>

                <div class="form-group mb-6">
                    <label class="form-label">{{ $trans('labels.email') }}</label>
                    <input type="email" class="form-input" v-model="form.email">
                    <span class="invalid-feedback" v-if="$page.errors.has('email')">{{ $page.errors.first('email') }}</span>
                </div>

                <div class="form-group mb-6">
                    <label class="form-label">{{ $trans('labels.password') }}</label>
                    <input type="password" class="form-input" v-model="form.password">
                    <span class="invalid-feedback" v-if="$page.errors.has('password')">{{ $page.errors.first('password') }}</span>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ $trans('labels.role') }}</label>
                    <select class="form-select" v-model="form.role">
                        <option value="admin">{{ $trans('labels.admin') }}</option>
                        <option value="user">{{ $trans('labels.user') }}</option>
                    </select>
                    <span class="invalid-feedback" v-if="$page.errors.has('role')">{{ $page.errors.first('role') }}</span>
                </div>
            </div>

            <div class="bg-gray-50 p-4 sm:px-6 sm:py-4 sm:flex sm:flex-row-reverse">
                <button type="button" class="btn btn-indigo" @click="submit()" :disabled="form.processing">
                    {{ $trans('labels.save-team-member') }}
                </button>

                <button type="button" class="btn btn-flat mr-3" @click="hide()">
                    {{ $trans('labels.cancel') }}
                </button>
            </div>
        </div>
    </v-modal>
</template>

<script>
    import VModal from '@/components/modal'
    import Form from '@/utils/form'

    export default {
        components: {
            VModal
        },

        props: {
            uuid: {
                type: String,
                required: true
            },
            name: {
                type: String,
                required: true
            },
            email: {
                type: String,
                required: true
            },
            role: {
                type: Number,
                required: true
            }
        },

        data() {
            return {
                form: new Form({
                    name: this.name,
                    email: this.email,
                    password: '',
                    role: this.role === 2 ? 'admin' : 'user',
                })
            }
        },

        methods: {
            show() {
                this.$refs.modal.show();
            },

            hide() {
                this.$refs.modal.hide();
            },

            submit() {
                this.form.processing = true;

                this.$inertia.put(route('app:users.update', {user: this.uuid}), this.form.data())
                    .then(() => {
                        this.form.processing = false;

                        if (this.$page.errors.none()) {
                            this.hide();
                            this.form.reset();
                        }
                    });
            }
        }
    }
</script>
