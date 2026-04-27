<script setup>
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Navbar from '@/Components/Navbar.vue';

// Props dari controller — nanti diisi saat backend sudah dibuat
// Untuk sekarang pakai dummy data
const props = defineProps({
    lazada: {
        type: Object,
        default: () => null // null = belum terhubung
    },
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
</script>

<template>
    <Head title="Integrasi API - OmniTerminal" />

    <div class="min-h-screen bg-[#0a0b0d] text-gray-300 font-sans relative">
        <Sidebar :is-collapsed="isSidebarCollapsed" @toggle="toggleSidebar" />

        <div class="transition-all duration-300 ease-in-out min-h-screen flex flex-col" :class="isSidebarCollapsed ? 'ml-[72px]' : 'ml-64'">
            <Navbar />

            <main class="p-6 lg:p-8 flex-1 pb-20">

                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-white tracking-wide flex items-center gap-2">
                        <span class="p-1.5 rounded bg-gradient-to-br from-[#8c52ff] to-[#5ce1e6] text-white">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                        </span>
                        Integrasi API
                    </h2>
                    <p class="text-gray-500 text-sm mt-2">Hubungkan toko kamu ke platform e-commerce untuk mengaktifkan sinkronisasi order dan stok otomatis.</p>
                </div>

                <!-- Grid Kartu Platform -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                    <!-- Kartu Lazada -->
                    <div class="bg-[#121317] border rounded-xl p-6 flex flex-col gap-4"
                        :class="props.lazada ? 'border-[#f57224]/30' : 'border-[#1f2128]'">

                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-[#f57224]/10 flex items-center justify-center flex-shrink-0">
                                <img src="/image/lazada_logo.png" alt="Lazada" class="w-7 h-7 object-contain" />
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-sm">Lazada</h3>
                                <p class="text-gray-600 text-xs">Lazada Open Platform</p>
                            </div>
                        </div>

                        <!-- Sudah terhubung -->
                        <div v-if="props.lazada">
                            <div class="bg-green-500/10 border border-green-500/20 rounded-lg px-3 py-2 mb-3">
                                <p class="text-green-400 text-xs font-bold flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 inline-block"></span>
                                    Terhubung
                                </p>
                                <p class="text-gray-500 text-xs mt-1">Seller ID: <span class="text-gray-300 font-mono">{{ props.lazada.seller_id }}</span></p>
                                <p class="text-gray-500 text-xs">Token expires: <span class="text-gray-300">{{ props.lazada.expire_at }}</span></p>
                            </div>
                            <button class="w-full bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 text-red-400 font-bold py-2 rounded-lg text-xs transition-all">
                                Putuskan Koneksi
                            </button>
                        </div>

                        <!-- Belum terhubung -->
                        <div v-else>
                            <div class="bg-[#1a1b20] border border-[#2d2f36] rounded-lg px-3 py-2 mb-3">
                                <p class="text-gray-500 text-xs font-bold flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-600 inline-block"></span>
                                    Belum Terhubung
                                </p>
                                <p class="text-gray-600 text-xs mt-1">Hubungkan akun Lazada Seller Center kamu untuk mengaktifkan sinkronisasi order & stok.</p>
                            </div>
                            <a
                                href="/lazada/connect"
                                class="w-full block text-center bg-gradient-to-r from-[#f57224] to-[#e05a10] hover:from-[#e05a10] hover:to-[#c94d0a] text-white font-bold py-2 rounded-lg text-xs transition-all"
                            >
                                Hubungkan Lazada
                            </a>
                        </div>
                    </div>

                    <!-- Kartu Meta Ads -->
                    <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-6 flex flex-col gap-4 opacity-60">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                                <img src="/image/meta_logo.png" alt="Meta Ads" class="w-7 h-7 object-contain" />
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-sm">Meta Ads</h3>
                                <p class="text-gray-600 text-xs">Meta Marketing API</p>
                            </div>
                        </div>
                        <div class="bg-[#1a1b20] border border-[#2d2f36] rounded-lg px-3 py-2">
                            <p class="text-gray-500 text-xs font-bold flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-600 inline-block"></span>
                                Segera Hadir
                            </p>
                            <p class="text-gray-600 text-xs mt-1">Integrasi Meta Ads sedang dalam pengembangan.</p>
                        </div>
                        <button disabled class="w-full bg-[#1a1b20] border border-[#2d2f36] text-gray-600 font-bold py-2 rounded-lg text-xs cursor-not-allowed">
                            Belum Tersedia
                        </button>
                    </div>

                    <!-- Kartu Shopee -->
                    <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-6 flex flex-col gap-4 opacity-60">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-orange-500/10 flex items-center justify-center flex-shrink-0">
                                <img src="/image/shopee_logo.png" alt="Shopee" class="w-7 h-7 object-contain" />
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-sm">Shopee</h3>
                                <p class="text-gray-600 text-xs">Shopee Open Platform</p>
                            </div>
                        </div>
                        <div class="bg-[#1a1b20] border border-[#2d2f36] rounded-lg px-3 py-2">
                            <p class="text-gray-500 text-xs font-bold flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-600 inline-block"></span>
                                Segera Hadir
                            </p>
                            <p class="text-gray-600 text-xs mt-1">Integrasi Shopee sedang dalam pengembangan.</p>
                        </div>
                        <button disabled class="w-full bg-[#1a1b20] border border-[#2d2f36] text-gray-600 font-bold py-2 rounded-lg text-xs cursor-not-allowed">
                            Belum Tersedia
                        </button>
                    </div>

                </div>

                <!-- Info Box -->
                <div class="mt-6 bg-[#121317] border border-[#1f2128] rounded-xl p-5 flex gap-4">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-[#8c52ff]/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#8c52ff]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-bold mb-1">Cara Kerja Integrasi</p>
                        <p class="text-gray-500 text-xs leading-relaxed">Setelah terhubung, sistem akan otomatis menarik data order dan menyinkronkan stok gudang ke platform e-commerce kamu. Token akan diperbarui otomatis sebelum masa berlakunya habis.</p>
                    </div>
                </div>

            </main>
        </div>
    </div>
</template>