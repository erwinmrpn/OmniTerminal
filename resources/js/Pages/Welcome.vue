<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome to OmniTerminal" />

    <div class="min-h-screen bg-gray-50 text-gray-900 flex flex-col justify-center items-center selection:bg-blue-500 selection:text-white">
        
        <div class="w-full max-w-2xl px-6 lg:max-w-7xl flex flex-col items-center">
            
            <div class="mb-8 text-center">
                <h1 class="text-5xl font-extrabold text-blue-600 tracking-tight">Omni<span class="text-gray-900">Terminal</span></h1>
                <p class="mt-4 text-lg text-gray-500">The Ultimate B2B SaaS for E-Commerce Operations</p>
            </div>

            <div v-if="canLogin" class="flex gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="rounded-md bg-blue-600 px-8 py-3 text-white font-semibold transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    Go to Dashboard
                </Link>

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="rounded-md bg-blue-600 px-8 py-3 text-white font-semibold shadow-md transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        Log In
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-md bg-white border border-gray-300 px-8 py-3 text-gray-700 font-semibold shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        Register Tenant
                    </Link>
                </template>
            </div>

            <div class="mt-16 text-center text-sm text-gray-400">
                &copy; 2026 OmniTerminal. All rights reserved.
            </div>
            
        </div>
    </div>
</template>