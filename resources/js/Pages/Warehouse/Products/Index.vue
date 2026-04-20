<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Navbar from '@/Components/Navbar.vue';

// Props yang dikirim dari ProductController
const props = defineProps({
    products: Array
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

// --- Form Tambah Produk Baru ---
const form = useForm({
    sku:           '',
    name:          '',
    price:         '',
    stock:         0,
    threshold_min: 10, // Default minimum stok sebelum low stock alert
    description:   '',
});

const submit = () => {
    form.post(route('products.store'), {
        onSuccess: () => form.reset(),
    });
};

// --- Logika Hapus Produk ---
const deleteProduct = (id, name) => {
    if (!confirm(`Hapus produk "${name}"? Semua riwayat stok produk ini juga akan terhapus.`)) return;
    router.delete(route('products.destroy', id));
};

// --- Logika Edit Produk ---
const showEditModal = ref(false);
const editForm = useForm({
    id:            null,
    sku:           '',
    name:          '',
    price:         '',
    stock:         0,
    threshold_min: 10,
    description:   '',
});

const openEdit = (product) => {
    editForm.id            = product.id;
    editForm.sku           = product.sku;
    editForm.name          = product.name;
    editForm.price         = product.price;
    editForm.stock         = product.stock;
    editForm.threshold_min = product.threshold_min;
    editForm.description   = product.description ?? '';
    showEditModal.value    = true;
};

const submitEdit = () => {
    editForm.put(route('products.update', editForm.id), {
        onSuccess: () => { showEditModal.value = false; },
    });
};

// --- Helper Format Harga ---
const formatRupiah = (value) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
};
</script>

<template>
    <Head title="Master Produk - OmniTerminal" />

    <div class="min-h-screen bg-[#0a0b0d] text-gray-300 font-sans relative">
        <Sidebar :is-collapsed="isSidebarCollapsed" @toggle="toggleSidebar" />

        <div class="transition-all duration-300 ease-in-out min-h-screen flex flex-col" :class="isSidebarCollapsed ? 'ml-[72px]' : 'ml-64'">
            <Navbar />

            <main class="p-6 lg:p-8 flex-1 pb-20">

                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-xl font-bold text-white tracking-wide flex items-center gap-2">
                        <span class="p-1.5 rounded bg-gradient-to-br from-[#8c52ff] to-[#5ce1e6] text-white">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        </span>
                        Master Produk
                    </h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Form Tambah Produk -->
                    <div class="lg:col-span-1">
                        <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-6 shadow-lg">
                            <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-6 border-b border-[#1f2128] pb-3">Tambah Produk Baru</h3>

                            <form @submit.prevent="submit" class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">SKU Internal</label>
                                    <input v-model="form.sku" type="text" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" placeholder="Misal: PRD-001" required>
                                    <div v-if="form.errors.sku" class="text-red-500 text-xs mt-1">{{ form.errors.sku }}</div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Produk</label>
                                    <input v-model="form.name" type="text" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" placeholder="Nama lengkap produk" required>
                                    <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Harga (Rp)</label>
                                    <input v-model="form.price" type="number" min="0" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" placeholder="0" required>
                                    <div v-if="form.errors.price" class="text-red-500 text-xs mt-1">{{ form.errors.price }}</div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Stok Awal</label>
                                        <input v-model="form.stock" type="number" min="0" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" required>
                                        <div v-if="form.errors.stock" class="text-red-500 text-xs mt-1">{{ form.errors.stock }}</div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Min. Stok</label>
                                        <input v-model="form.threshold_min" type="number" min="0" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" required>
                                        <div v-if="form.errors.threshold_min" class="text-red-500 text-xs mt-1">{{ form.errors.threshold_min }}</div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Deskripsi <span class="normal-case text-gray-600">(opsional)</span></label>
                                    <textarea v-model="form.description" rows="3" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff] resize-none" placeholder="Deskripsi singkat produk..."></textarea>
                                </div>

                                <button type="submit" :disabled="form.processing" class="w-full mt-2 bg-gradient-to-r from-[#8c52ff] to-[#5e17eb] hover:from-[#7b42ea] hover:to-[#4a0dd6] text-white font-bold py-2.5 rounded-md text-sm transition-all disabled:opacity-50">
                                    {{ form.processing ? 'Menyimpan...' : 'Simpan Produk' }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Tabel Daftar Produk -->
                    <div class="lg:col-span-2">
                        <div class="bg-[#121317] border border-[#1f2128] rounded-xl overflow-hidden shadow-lg h-full flex flex-col">
                            <div class="p-6 border-b border-[#1f2128] bg-[#1a1b20]/50">
                                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Daftar Produk</h3>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full text-left">
                                    <thead class="bg-[#0a0b0d] text-gray-500 uppercase text-[10px] tracking-wider font-bold">
                                        <tr>
                                            <th class="px-6 py-4 border-b border-[#1f2128]">SKU & Nama</th>
                                            <th class="px-6 py-4 border-b border-[#1f2128]">Harga</th>
                                            <th class="px-6 py-4 border-b border-[#1f2128]">Stok</th>
                                            <th class="px-6 py-4 border-b border-[#1f2128] text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#1f2128]">
                                        <tr v-for="product in props.products" :key="product.id" class="hover:bg-[#1a1b20]/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-gray-200 text-sm">{{ product.name }}</div>
                                                <div class="text-xs text-gray-500 font-mono">{{ product.sku }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-300">
                                                {{ formatRupiah(product.price) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <!-- Warna stok berubah jika mendekati/di bawah threshold -->
                                                <span class="text-sm font-bold"
                                                    :class="{
                                                        'text-red-400':    product.stock <= product.threshold_min,
                                                        'text-yellow-400': product.stock > product.threshold_min && product.stock <= product.threshold_min * 2,
                                                        'text-green-400':  product.stock > product.threshold_min * 2,
                                                    }"
                                                >{{ product.stock }}</span>
                                                <span class="text-xs text-gray-600 ml-1">/ min {{ product.threshold_min }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <!-- Tombol Edit -->
                                                <button @click="openEdit(product)" class="text-gray-500 hover:text-blue-400 transition-colors mr-3" title="Edit Produk">
                                                    <svg class="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                </button>
                                                <!-- Tombol Hapus -->
                                                <button @click="deleteProduct(product.id, product.name)" class="text-gray-500 hover:text-red-400 transition-colors" title="Hapus Produk">
                                                    <svg class="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr v-if="props.products.length === 0">
                                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic text-sm">
                                                Belum ada produk yang terdaftar.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Modal Edit Produk -->
    <div v-if="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">
        <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-6 w-full max-w-md shadow-xl">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-6 border-b border-[#1f2128] pb-3">Edit Produk</h3>

            <form @submit.prevent="submitEdit" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">SKU Internal</label>
                    <input v-model="editForm.sku" type="text" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" required>
                    <div v-if="editForm.errors.sku" class="text-red-500 text-xs mt-1">{{ editForm.errors.sku }}</div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Produk</label>
                    <input v-model="editForm.name" type="text" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" required>
                    <div v-if="editForm.errors.name" class="text-red-500 text-xs mt-1">{{ editForm.errors.name }}</div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Harga (Rp)</label>
                    <input v-model="editForm.price" type="number" min="0" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" required>
                    <div v-if="editForm.errors.price" class="text-red-500 text-xs mt-1">{{ editForm.errors.price }}</div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Stok</label>
                        <input v-model="editForm.stock" type="number" min="0" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" required>
                        <div v-if="editForm.errors.stock" class="text-red-500 text-xs mt-1">{{ editForm.errors.stock }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Min. Stok</label>
                        <input v-model="editForm.threshold_min" type="number" min="0" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" required>
                        <div v-if="editForm.errors.threshold_min" class="text-red-500 text-xs mt-1">{{ editForm.errors.threshold_min }}</div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Deskripsi <span class="normal-case text-gray-600">(opsional)</span></label>
                    <textarea v-model="editForm.description" rows="3" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff] resize-none"></textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showEditModal = false" class="flex-1 bg-[#1f2128] hover:bg-[#2d2f36] text-gray-300 font-bold py-2.5 rounded-md text-sm transition-all">
                        Batal
                    </button>
                    <button type="submit" :disabled="editForm.processing" class="flex-1 bg-gradient-to-r from-[#8c52ff] to-[#5e17eb] hover:from-[#7b42ea] hover:to-[#4a0dd6] text-white font-bold py-2.5 rounded-md text-sm transition-all disabled:opacity-50">
                        {{ editForm.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
select option {
    background-color: #121317;
    color: #e5e7eb;
}
</style>