<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen bg-[#0a0b0d] flex flex-col items-center justify-center px-4">

        <!-- Logo & Branding -->
        <div class="mb-8 text-center">
            <Link href="/" class="flex flex-col items-center gap-3">
                <!-- Logo OmniTerminal -->
                <img src="/image/logo_nobg.png" alt="OmniTerminal Logo" class="w-20 h-20 object-contain">
                <!-- Nama Sistem -->
                <span class="text-xl font-bold text-white tracking-wide">OmniTerminal</span>
            </Link>
            <p class="text-xs text-gray-600 mt-2 tracking-widest uppercase">Warehouse Management System</p>
        </div>

        <!-- Card Form -->
        <div class="w-full max-w-md bg-[#121317] border border-[#1f2128] rounded-xl px-8 py-8 shadow-2xl">
            <slot />
        </div>

    </div>
</template>