<script setup>
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Navbar from '@/Components/Navbar.vue';

const isSidebarCollapsed = ref(false);

const toggleSidebar = () => {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
    localStorage.setItem("sidebar_collapsed", String(isSidebarCollapsed.value));
}

onMounted(() => {
    const savedSidebar = localStorage.getItem("sidebar_collapsed");
    if (savedSidebar === "true") isSidebarCollapsed.value = true;
});

// Mockup data untuk Finance
const financeStats = [
    { name: 'Total Revenue', value: 'Rp 120.500.000', icon: '📈', textColor: 'text-green-400', bgColor: 'bg-green-500/10', borderColor: 'border-green-500/20' },
    { name: 'Pending Invoices', value: '4 Tagihan', icon: '⏳', textColor: 'text-yellow-400', bgColor: 'bg-yellow-500/10', borderColor: 'border-yellow-500/20' },
    { name: 'Net Profit', value: 'Rp 45.000.000', icon: '💎', textColor: 'text-blue-400', bgColor: 'bg-blue-500/10', borderColor: 'border-blue-500/20' },
];
</script>

<template>
    <Head title="Finance Dashboard - OmniTerminal" />

    <div class="min-h-screen bg-[#0a0b0d] text-gray-300 font-sans relative">
        <Sidebar :is-collapsed="isSidebarCollapsed" @toggle="toggleSidebar" />

        <div class="transition-all duration-300 ease-in-out min-h-screen flex flex-col" :class="isSidebarCollapsed ? 'ml-[72px]' : 'ml-64'">
            <Navbar />

            <main class="p-6 lg:p-8 space-y-8 flex-1 pb-20">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white tracking-wide flex items-center gap-2">
                        <span class="p-1.5 rounded bg-gradient-to-br from-[#10b981] to-[#047857] text-white">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </span>
                        Dashboard Keuangan
                    </h2>
                    <span class="bg-[#1a1b20] border border-[#2d2f36] text-green-400 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">
                        Role: Finance
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div v-for="item in financeStats" :key="item.name" class="relative group p-[1px] rounded-xl bg-gradient-to-r from-[#2d2f36] to-[#1f2128] hover:from-[#10b981] hover:to-[#047857] transition-all duration-300 shadow-sm">
                        <div class="bg-[#121317] rounded-xl p-6 h-full relative overflow-hidden flex items-center">
                            <div :class="[item.bgColor, item.borderColor, item.textColor, 'p-4 rounded-lg mr-4 text-2xl border']">
                                {{ item.icon }}
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">{{ item.name }}</p>
                                <h3 class="text-2xl font-black text-white tracking-tight">{{ item.value }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>