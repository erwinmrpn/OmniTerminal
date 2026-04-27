<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin:    { type: Boolean },
    canRegister: { type: Boolean },
});
</script>

<template>
    <Head title="OmniTerminal — Warehouse Management System" />

    <div class="min-h-screen bg-[#0a0b0d] text-gray-300 font-sans flex flex-col">

        <!-- Background glow effect (CSS only, ringan) -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden">
            <div class="absolute top-[-100px] left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-[#8c52ff] rounded-full blur-[160px] opacity-[0.07]"></div>
        </div>

        <!-- Navbar -->
        <nav class="relative z-10 flex items-center justify-between px-8 py-5 border-b border-[#1f2128]">
            <div class="flex items-center gap-3">
                <img src="/image/logo_nobg.png" alt="OmniTerminal" class="w-8 h-8 object-contain" />
                <span class="font-bold text-white text-lg tracking-wide">OmniTerminal</span>
            </div>

            <div v-if="canLogin" class="flex items-center gap-3">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="bg-[#8c52ff] hover:bg-[#7b42ea] text-white text-sm font-bold px-5 py-2 rounded-lg transition-all"
                >
                    Go to Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="text-sm font-bold text-gray-400 hover:text-white transition-colors px-4 py-2"
                    >
                        Log In
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="bg-[#8c52ff] hover:bg-[#7b42ea] text-white text-sm font-bold px-5 py-2 rounded-lg transition-all"
                    >
                        Register
                    </Link>
                </template>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative z-10 flex-1 flex flex-col items-center justify-center px-6 text-center py-20">

            <!-- Logo -->
            <div class="mb-8">
                <img src="/image/logo_nobg.png" alt="OmniTerminal Logo" class="w-24 h-24 object-contain mx-auto drop-shadow-[0_0_30px_rgba(140,82,255,0.4)]" />
            </div>

            <!-- Headline -->
            <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-4 leading-tight">
                Omni<span class="text-[#5ce1e6]">Terminal</span>
            </h1>

            <p class="text-gray-500 text-sm uppercase tracking-[0.3em] mb-6 font-medium">
                Warehouse Management System
            </p>

            <!-- CTA Buttons -->
            <div v-if="canLogin" class="flex flex-col sm:flex-row gap-3 justify-center">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="bg-gradient-to-r from-[#8c52ff] to-[#5e17eb] hover:from-[#7b42ea] hover:to-[#4a0dd6] text-white font-bold px-8 py-3 rounded-xl text-sm transition-all shadow-[0_0_20px_rgba(140,82,255,0.3)]"
                >
                    Masuk ke Dashboard →
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="bg-gradient-to-r from-[#8c52ff] to-[#5e17eb] hover:from-[#7b42ea] hover:to-[#4a0dd6] text-white font-bold px-8 py-3 rounded-xl text-sm transition-all shadow-[0_0_20px_rgba(140,82,255,0.3)]"
                    >
                        Masuk ke Sistem →
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="bg-[#1a1b20] hover:bg-[#2d2f36] border border-[#2d2f36] text-gray-300 font-bold px-8 py-3 rounded-xl text-sm transition-all"
                    >
                        Daftar Tenant
                    </Link>
                </template>
            </div>
        </main>

        <!-- Feature Cards -->
        <section class="relative z-10 px-6 pb-16 max-w-4xl mx-auto w-full">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-5">
                    <div class="w-9 h-9 rounded-lg bg-[#8c52ff]/10 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-[#8c52ff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-white font-bold text-sm mb-1">Manajemen Stok</h3>
                    <p class="text-gray-500 text-xs leading-relaxed">Pantau stok gudang secara real-time dengan alert stok menipis otomatis.</p>
                </div>

                <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-5">
                    <div class="w-9 h-9 rounded-lg bg-[#5ce1e6]/10 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-[#5ce1e6]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <h3 class="text-white font-bold text-sm mb-1">Proses Order</h3>
                    <p class="text-gray-500 text-xs leading-relaxed">Scan resi, update status packing, dan kelola alur order dari satu dashboard.</p>
                </div>

                <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-5">
                    <div class="w-9 h-9 rounded-lg bg-[#f43f5e]/10 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-[#f43f5e]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-white font-bold text-sm mb-1">Multi Tenant</h3>
                    <p class="text-gray-500 text-xs leading-relaxed">Setiap toko punya data terisolasi dengan manajemen tim dan role akses sendiri.</p>
                </div>

            </div>
        </section>

        <!-- Footer -->
        <footer class="relative z-10 border-t border-[#1f2128] py-5 text-center">
            <p class="text-xs text-gray-600">&copy; 2026 OmniTerminal. All rights reserved.</p>
        </footer>

    </div>
</template>