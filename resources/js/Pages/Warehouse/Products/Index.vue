<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Navbar from '@/Components/Navbar.vue';

// Props yang dikirim dari ProductController
const props = defineProps({
    products:          Array,
    channels:          Array,  // Daftar semua channel aktif (Lazada, Tokopedia, dll)
    selectedChannelId: Number, // Channel yang sedang aktif dipilih
});

// Sidebar Logic
const isSidebarCollapsed = ref(false);
const toggleSidebar = () => {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
    localStorage.setItem("sidebar_collapsed", String(isSidebarCollapsed.value));
}
onMounted(() => {
    const savedSidebar = localStorage.getItem("sidebar_collapsed");
    if (savedSidebar === "true") isSidebarCollapsed.value = true;
});

// --- Filter Channel ---
// Pindah ke channel yang dipilih dengan reload halaman
const selectChannel = (channelId) => {
    router.get(route('products.index'), 
        channelId ? { channel_id: channelId } : {},
        { preserveState: false }
    );
};

// --- Edit Threshold Minimum Stok ---
// Hanya field ini yang boleh diubah dari sistem (bukan dari platform e-commerce)
const editingThresholdId = ref(null); // ID produk yang sedang diedit thresholdnya
const thresholdForm = useForm({ threshold_min: 0 });

const openEditThreshold = (product) => {
    editingThresholdId.value  = product.id;
    thresholdForm.threshold_min = product.threshold_min;
};

const saveThreshold = (productId) => {
    thresholdForm.patch(route('products.threshold', productId), {
        onSuccess: () => { editingThresholdId.value = null; },
    });
};

const cancelEditThreshold = () => {
    editingThresholdId.value = null;
};

// --- Helper: ambil channel_sku produk dari channel yang aktif ---
const getChannelSku = (product) => {
    if (!product.product_channels || product.product_channels.length === 0) return '-';
    return product.product_channels[0]?.channel_sku ?? '-';
};
</script>

<template>
    <Head title="Master Produk - OmniTerminal" />

    <div class="min-h-screen bg-[#0a0b0d] text-gray-300 font-sans relative">
        <Sidebar :is-collapsed="isSidebarCollapsed" @toggle="toggleSidebar" />

        <div class="transition-all duration-300 ease-in-out min-h-screen flex flex-col" :class="isSidebarCollapsed ? 'ml-[72px]' : 'ml-64'">
            <Navbar />

            <main class="p-6 lg:p-8 flex-1 pb-20">

                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-white tracking-wide flex items-center gap-2">
                        <span class="p-1.5 rounded bg-gradient-to-br from-[#8c52ff] to-[#5ce1e6] text-white">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        </span>
                        Master Produk
                    </h2>
                    <span class="text-xs text-gray-500">
                        {{ props.products.length }} produk ditemukan
                    </span>
                </div>

                <!-- Tab Filter Channel -->
                <div class="flex gap-2 mb-6 flex-wrap">
                    <!-- Tab "Semua" -->
                    <button
                        @click="selectChannel(null)"
                        class="px-4 py-2 rounded-md text-xs font-bold uppercase tracking-wider transition-all"
                        :class="!props.selectedChannelId
                            ? 'bg-[#8c52ff] text-white'
                            : 'bg-[#1f2128] text-gray-400 hover:text-white'"
                    >
                        Semua Platform
                    </button>

                    <!-- Tab per Channel -->
                    <button
                        v-for="channel in props.channels"
                        :key="channel.id"
                        @click="selectChannel(channel.id)"
                        class="px-4 py-2 rounded-md text-xs font-bold uppercase tracking-wider transition-all"
                        :class="props.selectedChannelId === channel.id
                            ? 'bg-[#8c52ff] text-white'
                            : 'bg-[#1f2128] text-gray-400 hover:text-white'"
                    >
                        {{ channel.name }}
                    </button>
                </div>

                <!-- Tabel Produk -->
                <div class="bg-[#121317] border border-[#1f2128] rounded-xl overflow-hidden shadow-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left">
                            <thead class="bg-[#0a0b0d] text-gray-500 uppercase text-[10px] tracking-wider font-bold">
                                <tr>
                                    <th class="px-6 py-4 border-b border-[#1f2128]">No</th>
                                    <th class="px-6 py-4 border-b border-[#1f2128]">SKU Platform</th>
                                    <th class="px-6 py-4 border-b border-[#1f2128]">Nama Produk</th>
                                    <th class="px-6 py-4 border-b border-[#1f2128]">Stok</th>
                                    <!-- Kolom threshold bisa diedit, lainnya read-only -->
                                    <th class="px-6 py-4 border-b border-[#1f2128]">Batas Min. Stok</th>
                                    <th class="px-6 py-4 border-b border-[#1f2128]">Status</th>
                                    <th class="px-6 py-4 border-b border-[#1f2128]">Diperbarui</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#1f2128]">
                                <tr v-for="(product, index) in props.products" :key="product.id" class="hover:bg-[#1a1b20]/50 transition-colors">

                                    <!-- No -->
                                    <td class="px-6 py-4 text-xs text-gray-500">{{ index + 1 }}</td>

                                    <!-- SKU dari platform e-commerce (read-only) -->
                                    <td class="px-6 py-4 text-xs text-gray-400 font-mono">
                                        {{ getChannelSku(product) }}
                                    </td>

                                    <!-- Nama Produk (read-only) -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-200">{{ product.name }}</div>
                                        <div class="text-xs text-gray-600 font-mono mt-0.5">{{ product.sku }}</div>
                                    </td>

                                    <!-- Stok (read-only, warna berdasarkan threshold) -->
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-bold"
                                            :class="{
                                                'text-red-400':    product.stock <= product.threshold_min,
                                                'text-yellow-400': product.stock > product.threshold_min && product.stock <= product.threshold_min * 2,
                                                'text-green-400':  product.stock > product.threshold_min * 2,
                                            }"
                                        >{{ product.stock }}</span>
                                    </td>

                                    <!-- Batas Min Stok (SATU-SATUNYA yang bisa diedit) -->
                                    <td class="px-6 py-4">
                                        <!-- Mode normal: tampilkan nilai + tombol edit -->
                                        <div v-if="editingThresholdId !== product.id" class="flex items-center gap-2">
                                            <span class="text-sm text-gray-300">{{ product.threshold_min }}</span>
                                            <button @click="openEditThreshold(product)" class="text-gray-600 hover:text-[#8c52ff] transition-colors" title="Ubah Batas Minimum">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                            </button>
                                        </div>

                                        <!-- Mode edit: input inline + tombol simpan/batal -->
                                        <div v-else class="flex items-center gap-2">
                                            <input
                                                v-model="thresholdForm.threshold_min"
                                                type="number" min="0"
                                                class="w-16 bg-[#0a0b0d] border border-[#8c52ff] rounded px-2 py-1 text-sm text-gray-300 focus:outline-none"
                                                @keyup.enter="saveThreshold(product.id)"
                                                @keyup.escape="cancelEditThreshold"
                                                autofocus
                                            >
                                            <!-- Simpan -->
                                            <button @click="saveThreshold(product.id)" class="text-green-400 hover:text-green-300 transition-colors" title="Simpan">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            </button>
                                            <!-- Batal -->
                                            <button @click="cancelEditThreshold" class="text-gray-500 hover:text-red-400 transition-colors" title="Batal">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        </div>
                                    </td>

                                    <!-- Status Aktif/Nonaktif (read-only) -->
                                    <td class="px-6 py-4">
                                        <span class="text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider border"
                                            :class="product.is_active
                                                ? 'bg-green-500/10 text-green-400 border-green-500/20'
                                                : 'bg-gray-500/10 text-gray-500 border-gray-500/20'"
                                        >
                                            {{ product.is_active ? 'Active' : 'Nonaktif' }}
                                        </span>
                                    </td>

                                    <!-- Tanggal terakhir diperbarui (read-only) -->
                                    <td class="px-6 py-4 text-xs text-gray-500 font-mono">
                                        {{ new Date(product.updated_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                                    </td>
                                </tr>

                                <!-- Empty state -->
                                <tr v-if="props.products.length === 0">
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="text-gray-600 text-sm italic">Belum ada produk dari platform ini.</div>
                                        <div class="text-gray-700 text-xs mt-1">Hubungkan akun e-commerce terlebih dahulu untuk sinkronisasi produk.</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>
</template>