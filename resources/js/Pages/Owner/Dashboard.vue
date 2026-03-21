<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Navbar from '@/Components/Navbar.vue';

// --- STATE SIDEBAR ADAPTIF ---
const isSidebarCollapsed = ref(false);

const toggleSidebar = () => {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
    localStorage.setItem("sidebar_collapsed", String(isSidebarCollapsed.value));
}

onMounted(() => {
    const savedSidebar = localStorage.getItem("sidebar_collapsed");
    if (savedSidebar === "true") isSidebarCollapsed.value = true;
});

// --- DATA STATISTIK ---
// Warna background dan text disesuaikan untuk Dark Mode
const stats = [
    { name: 'Total SKU Produk', value: '124', icon: '📦', textColor: 'text-blue-400', bgColor: 'bg-blue-500/10', borderColor: 'border-blue-500/20' },
    { name: 'Stok Menipis', value: '8', icon: '⚠️', textColor: 'text-red-400', bgColor: 'bg-red-500/10', borderColor: 'border-red-500/20' },
    { name: 'Estimasi Nilai Aset', value: 'Rp 45.500.000', icon: '💰', textColor: 'text-green-400', bgColor: 'bg-green-500/10', borderColor: 'border-green-500/20' },
];
</script>

<template>
    <Head title="Owner Dashboard - OmniTerminal" />

    <div class="min-h-screen bg-[#0a0b0d] text-gray-300 font-sans relative">
        
        <Sidebar :is-collapsed="isSidebarCollapsed" @toggle="toggleSidebar" />

        <div class="transition-all duration-300 ease-in-out min-h-screen flex flex-col" :class="isSidebarCollapsed ? 'ml-[72px]' : 'ml-64'">
            
            <Navbar />

            <main class="p-6 lg:p-8 space-y-8 flex-1 pb-20">
                
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white tracking-wide flex items-center gap-2">
                        <span class="p-1.5 rounded bg-gradient-to-br from-[#8c52ff] to-[#5e17eb] text-white">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        </span>
                        Dashboard Utama
                    </h2>
                    <span class="bg-[#1a1b20] border border-[#2d2f36] text-blue-400 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">
                        Role: Owner
                    </span>
                </div>

                <div class="relative p-[1px] rounded-xl bg-gradient-to-r from-[#8c52ff] to-[#5ce1e6] shadow-lg">
                    <div class="bg-[#121317] rounded-xl p-6 relative overflow-hidden flex flex-col md:flex-row justify-between items-center z-10">
                        <div class="absolute -top-[50px] -right-[50px] w-[200px] h-[200px] bg-[#8c52ff] rounded-full blur-[80px] opacity-20 pointer-events-none z-0"></div>
                        
                        <div class="relative z-10">
                            <h3 class="text-2xl font-black text-white tracking-tight">Selamat Datang, {{ $page.props.auth.user.name }}!</h3>
                            <p class="text-sm text-gray-400 mt-1">Pantau seluruh pergerakan gudang dan bisnis Anda di sini.</p>
                        </div>
                        <div class="mt-4 md:mt-0 flex space-x-3 relative z-10">
                            <Link 
                                :href="route('products.index')" 
                                class="inline-flex items-center px-5 py-2.5 bg-[#1a1b20] border border-[#2d2f36] rounded-md font-bold text-[10px] text-white uppercase tracking-widest hover:bg-[#25262c] hover:border-gray-500 transition-all shadow-sm"
                            >
                                Kelola Master Produk
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-down">
                    <div v-for="item in stats" :key="item.name" class="relative group p-[1px] rounded-xl bg-gradient-to-r from-[#2d2f36] to-[#1f2128] hover:from-[#8c52ff] hover:to-[#5ce1e6] transition-all duration-300 shadow-sm">
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-auto">
                    <div class="relative p-[1px] rounded-xl bg-gradient-to-b from-[#2d2f36] to-transparent">
                        <div class="bg-[#121317] rounded-xl overflow-hidden h-full flex flex-col">
                            <div class="p-5 border-b border-[#1f2128] flex justify-between items-center bg-[#1a1b20]/50">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                                    Aktivitas Gudang Hari Ini
                                </h3>
                            </div>
                            <div class="flex-1 flex items-center justify-center p-8">
                                <p class="text-center text-gray-600 text-xs font-medium italic border border-dashed border-[#2d2f36] rounded-lg p-6 w-full">
                                    Belum ada aktivitas barang masuk/keluar hari ini.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="relative p-[1px] rounded-xl bg-gradient-to-b from-[#2d2f36] to-transparent opacity-80">
                        <div class="bg-[#121317] rounded-xl overflow-hidden h-full flex flex-col">
                            <div class="p-5 border-b border-[#1f2128] flex justify-between items-center bg-[#1a1b20]/50">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>
                                    Performa Iklan (ROAS)
                                </h3>
                                <span class="text-[9px] bg-[#1f2128] text-gray-500 font-bold px-2 py-1 rounded uppercase border border-[#2d2f36]">Segera Hadir</span>
                            </div>
                            <div class="flex-1 flex items-center justify-center p-8">
                                <p class="text-center text-gray-600 text-xs font-medium italic border border-dashed border-[#2d2f36] rounded-lg p-6 w-full">
                                    Modul integrasi Meta/TikTok Ads sedang dalam pengembangan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
</template>

<style scoped>
@keyframes fadeInDown { 
    from { opacity: 0; transform: translateY(-10px); } 
    to { opacity: 1; transform: translateY(0); } 
}
.animate-fade-in-down { 
    animation: fadeInDown 0.4s ease-out forwards; 
}
</style>