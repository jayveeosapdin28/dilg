<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

        <form @submit.prevent="submit">
            <div class="mt-4">
                <VTextField
                    density="comfortable"
                    color="primary"
                    type="email"
                    label="Email"
                    variant="outlined"
                    v-model="form.email"
                    :error-messages="form.errors.email"
                />
            </div>

            <div class="mt-2">
                <VTextField
                    density="comfortable"
                    color="primary"
                    type="password"
                    label="Password"
                    variant="outlined"
                    v-model="form.password"
                    :error-messages="form.errors.password"
                />
            </div>

            <div class="mt-2">
                <VTextField
                    density="comfortable"
                    color="primary"
                    type="password"
                    label="Confirm Password"
                    variant="outlined"
                    v-model="form.password_confirmation"
                    :error-messages="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 flex justify-center flex-col">
                <VBtn type="submit" class="w-full" variant="flat" color="primary" size="large" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reset Password
                </VBtn>
            </div>
        </form>
    </GuestLayout>
</template>
