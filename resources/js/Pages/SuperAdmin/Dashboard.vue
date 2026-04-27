<script setup>
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Navbar from '@/Components/Navbar.vue';

// Props dari SuperAdminController@dashboard
// Cukup kirim angka-angka summary, tidak perlu kirim array penuh
const props = defineProps({
    totalTenants:    Number,
    activeTenants:   Number,
    inactiveTenants: Number,
    totalUsers:      Number,
    usersByRole:     Object, // { owner: 3, manager: 2, warehouse: 5, ... }
});

// Sidebar Logic
const isSidebarCollapsed = ref(false);
const toggleSidebar = () => {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
    localStorage.setItem("sidebar_collapsed", String(isSidebarCollapsed.value));
};
onMounted(() => {
    const savedSidebar = localStorage.getItem("sidebar_collapsed");
    if (savedSidebar === "true") isSidebarCollapsed.value = true;
});

// Daftar role untuk ditampilkan di grid distribusi
const roles = [
    { key: 'owner',     label: 'Owner',     color: 'text-yellow-400' },
    { key: 'manager',   label: 'Manager',   color: 'text-purple-400' },
    { key: 'warehouse', label: 'Warehouse', color: 'text-blue-400'   },
    { key: 'marketing', label: 'Marketing', color: 'text-pink-400'   },
    { key: 'finance',   label: 'Finance',   color: 'text-green-400'  },
];
</script>

<template>
    <Head title="Super Admin Dashboard - OmniTerminal" />

    <div class="min-h-screen bg-[#0a0b0d] text-gray-300 font-sans relative">
        <Sidebar :is-collapsed="isSidebarCollapsed" @toggle="toggleSidebar" />

        <div class="transition-all duration-300 ease-in-out min-h-screen flex flex-col" :class="isSidebarCollapsed ? 'ml-[72px]' : 'ml-64'">
            <Navbar />

            <main class="p-6 lg:p-8 flex-1 pb-20">

                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-xl font-bold text-white tracking-wide flex items-center gap-2">
                        <span class="p-1.5 rounded bg-gradient-to-br from-[#f43f5e] to-[#be123c] text-white shadow-[0_0_15px_rgba(244,63,94,0.4)]">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </span>
                        Super Admin Dashboard
                    </h2>
                    <span class="bg-[#1a1b20] border border-red-900/50 text-red-400 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                        God Mode
                    </span>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-5">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Total Tenant</p>
                        <p class="text-3xl font-bold text-white">{{ props.totalTenants }}</p>
                    </div>
                    <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-5">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Tenant Aktif</p>
                        <p class="text-3xl font-bold text-green-400">{{ props.activeTenants }}</p>
                    </div>
                    <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-5">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Tenant Nonaktif</p>
                        <p class="text-3xl font-bold text-red-400">{{ props.inactiveTenants }}</p>
                    </div>
                    <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-5">
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">Total User</p>
                        <p class="text-3xl font-bold text-white">{{ props.totalUsers }}</p>
                    </div>
                </div>

                <!-- Distribusi Role -->
                <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-6 mb-6">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-5">Distribusi Role User</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                        <div v-for="role in roles" :key="role.key"
                            class="bg-[#0a0b0d] border border-[#2d2f36] rounded-lg p-4 text-center">
                            <p class="text-2xl font-bold mb-1" :class="role.color">
                                {{ props.usersByRole?.[role.key] ?? 0 }}
                            </p>
                            <p class="text-[10px] text-gray-500 uppercase tracking-wider">{{ role.label }}</p>
                        </div>
                    </div>
                </div>

                <!-- Placeholder Chart Area (akan diisi saat ApexCharts diinstall) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- Chart: Pertumbuhan Tenant -->
                    <div class="bg-[#121317] border border-dashed border-[#2d2f36] rounded-xl p-8 flex flex-col items-center justify-center min-h-[220px] text-center">
                        <svg class="w-8 h-8 text-gray-700 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                        </svg>
                        <p class="text-gray-600 text-sm font-medium">Grafik Pertumbuhan Tenant</p>
                        <p class="text-gray-700 text-xs mt-1">Akan ditampilkan setelah ApexCharts diinstall</p>
                    </div>

                    <!-- Chart: Distribusi Tenant Aktif vs Nonaktif -->
                    <div class="bg-[#121317] border border-dashed border-[#2d2f36] rounded-xl p-8 flex flex-col items-center justify-center min-h-[220px] text-center">
                        <svg class="w-8 h-8 text-gray-700 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                        </svg>
                        <p class="text-gray-600 text-sm font-medium">Chart Tenant Aktif vs Nonaktif</p>
                        <p class="text-gray-700 text-xs mt-1">Akan ditampilkan setelah ApexCharts diinstall</p>
                    </div>

                </div>

            </main>
        </div>
    </div>
</template>

<style scoped>
/* Scrollbar tipis */
::-webkit-scrollbar { width: 4px; height: 4px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
</style>
