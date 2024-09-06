<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div class="flex justify-center mb-6">
            <span class="text-accent text-lg font-semibold">Please enter your credentials</span>
        </div>

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

            <div class="flex items-center flex-col mt-4">

                <VBtn type="sumbit" variant="flat"  size="large" color="primary" class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </VBtn>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="mt-6 text-center font-semibold  text-accent hover:text-accent-secondary rounded-md focus:outline-none focus:ring-none "
                >
                    Forgot your password?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>


