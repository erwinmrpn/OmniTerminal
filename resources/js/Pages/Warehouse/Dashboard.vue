<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard (Tahap Pengembangan)
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-900 font-medium text-lg">
                        Selamat datang, {{ $page.props.auth.user.name }}!
                    </p>
                    <p class="text-gray-500 mt-2">
                        Role Anda saat ini adalah: <span class="uppercase font-bold text-blue-600">{{ $page.props.auth.user.role }}</span>
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>