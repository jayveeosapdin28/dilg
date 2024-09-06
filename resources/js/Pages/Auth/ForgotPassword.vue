<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="mb-4 text-primary  text-gray-600">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset
            link that will allow you to choose a new one.
        </div>

        <VAlert v-if="status" type="success"  variant="tonal" :text="status"></VAlert>

        <form @submit.prevent="submit">
            <div class="mt-8">
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

            <div class="mt-4 flex justify-center flex-col">
                <VBtn type="submit" class="w-full" variant="flat" color="primary" size="large" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Email Password Reset Link
                </VBtn>
                <Link
                    :href="route('login')"
                    class="mt-6 text-center font-semibold  text-accent hover:text-accent-secondary rounded-md focus:outline-none focus:ring-none "
                >
                    Login here
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
