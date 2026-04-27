<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Navbar from '@/Components/Navbar.vue';

// Props dari SuperAdminController@tenants
const props = defineProps({
    tenants: Array,
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

// --- Form Tambah Tenant Baru ---
const addForm = useForm({
    name: '',
});

const submitAdd = () => {
    addForm.post(route('superadmin.tenants.store'), {
        onSuccess: () => addForm.reset(),
    });
};

// --- Logika Edit Tenant ---
const showEditModal = ref(false);
const editForm = useForm({
    id:        null,
    name:      '',
    is_active: true,
});

const openEdit = (tenant) => {
    editForm.id        = tenant.id;
    editForm.name      = tenant.name;
    // Ubah nilai 1/0 dari DB ke boolean JS
    editForm.is_active = tenant.is_active === 1 || tenant.is_active === true;
    showEditModal.value = true;
};

const submitEdit = () => {
    editForm.put(route('superadmin.tenants.update', editForm.id), {
        preserveScroll: true,
        onSuccess: () => { showEditModal.value = false; },
    });
};

// --- Logika Hapus Tenant ---
const deleteTenant = (id, name) => {
    if (!confirm(`Hapus tenant "${name}"?\n\nSemua akun owner, staff, dan data milik tenant ini akan ikut terhapus permanen.`)) return;
    router.delete(route('superadmin.tenants.destroy', id));
};
</script>

<template>
    <Head title="Kelola Tenant - OmniTerminal" />

    <div class="min-h-screen bg-[#0a0b0d] text-gray-300 font-sans relative">
        <Sidebar :is-collapsed="isSidebarCollapsed" @toggle="toggleSidebar" />

        <div class="transition-all duration-300 ease-in-out min-h-screen flex flex-col" :class="isSidebarCollapsed ? 'ml-[72px]' : 'ml-64'">
            <Navbar />

            <main class="p-6 lg:p-8 flex-1 pb-20">

                <!-- Page Header -->
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-xl font-bold text-white tracking-wide flex items-center gap-2">
                        <span class="p-1.5 rounded bg-gradient-to-br from-[#8c52ff] to-[#5ce1e6] text-white">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V7a2 2 0 012-2h4l2-3h4l2 3h4a2 2 0 012 2v12a2 2 0 01-2 2z"/>
                            </svg>
                        </span>
                        Kelola Tenant
                    </h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Form Tambah Tenant Baru -->
                    <div class="lg:col-span-1">
                        <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-6 shadow-lg">
                            <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-6 border-b border-[#1f2128] pb-3">Tambah Tenant Baru</h3>

                            <form @submit.prevent="submitAdd" class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Toko / Bisnis</label>
                                    <input
                                        v-model="addForm.name"
                                        type="text"
                                        class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]"
                                        placeholder="Misal: Toko Makmur Jaya"
                                        required
                                    >
                                    <div v-if="addForm.errors.name" class="text-red-400 text-xs mt-1">{{ addForm.errors.name }}</div>
                                </div>

                                <button
                                    type="submit"
                                    :disabled="addForm.processing"
                                    class="w-full bg-gradient-to-r from-[#8c52ff] to-[#5e17eb] hover:from-[#7b42ea] hover:to-[#4a0dd6] text-white font-bold py-2.5 rounded-md text-sm transition-all disabled:opacity-50"
                                >
                                    {{ addForm.processing ? 'Menyimpan...' : 'Tambah Tenant' }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Tabel Daftar Tenant -->
                    <div class="lg:col-span-2">
                        <div class="bg-[#121317] border border-[#1f2128] rounded-xl overflow-hidden shadow-lg">
                            <div class="p-5 border-b border-[#1f2128] bg-[#1a1b20]/50 flex justify-between items-center">
                                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Daftar Tenant</h3>
                                <span class="text-xs text-gray-500 font-mono">{{ props.tenants.length }} Tenant</span>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full text-left">
                                    <thead class="bg-[#0a0b0d] text-gray-500 uppercase text-[10px] tracking-wider font-bold">
                                        <tr>
                                            <th class="px-5 py-4 border-b border-[#1f2128]">Nama Toko</th>
                                            <th class="px-5 py-4 border-b border-[#1f2128]">Status</th>
                                            <th class="px-5 py-4 border-b border-[#1f2128]">Total Akun</th>
                                            <th class="px-5 py-4 border-b border-[#1f2128]">Dibuat</th>
                                            <th class="px-5 py-4 border-b border-[#1f2128] text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#1f2128]">
                                        <tr v-for="tenant in props.tenants" :key="tenant.id" class="hover:bg-[#1a1b20]/50 transition-colors">
                                            <td class="px-5 py-4 font-bold text-gray-200 text-sm">{{ tenant.name }}</td>
                                            <td class="px-5 py-4">
                                                <span class="text-[9px] font-bold px-2 py-1 rounded border uppercase"
                                                    :class="tenant.is_active
                                                        ? 'bg-green-500/10 text-green-400 border-green-500/20'
                                                        : 'bg-red-500/10 text-red-400 border-red-500/20'"
                                                >
                                                    {{ tenant.is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-4 text-xs text-gray-400">{{ tenant.users_count }} Akun</td>
                                            <td class="px-5 py-4 text-xs text-gray-500 font-mono">
                                                {{ new Date(tenant.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                                            </td>
                                            <td class="px-5 py-4 text-right flex justify-end gap-2">
                                                <!-- Tombol Edit -->
                                                <button @click="openEdit(tenant)" class="text-blue-500 hover:text-blue-400 font-bold text-[10px] uppercase border border-blue-500/30 px-2 py-1 rounded bg-blue-500/10 transition-colors">
                                                    Edit
                                                </button>
                                                <!-- Tombol Hapus -->
                                                <button @click="deleteTenant(tenant.id, tenant.name)" class="text-red-500 hover:text-red-400 font-bold text-[10px] uppercase border border-red-500/30 px-2 py-1 rounded bg-red-500/10 transition-colors">
                                                    Hapus
                                                </button>
                                            </td>
                                        </tr>
                                        <tr v-if="props.tenants.length === 0">
                                            <td colspan="5" class="px-5 py-12 text-center text-gray-600 italic text-sm">
                                                Belum ada tenant yang terdaftar.
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

    <!-- Modal Edit Tenant -->
    <div v-if="showEditModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm">
        <div class="bg-[#121317] border border-[#2d2f36] rounded-xl p-6 w-full max-w-md shadow-2xl">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-6 border-b border-[#1f2128] pb-3">Edit Tenant</h3>

            <form @submit.prevent="submitEdit" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Toko</label>
                    <input
                        v-model="editForm.name"
                        type="text"
                        class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]"
                        required
                    >
                    <div v-if="editForm.errors.name" class="text-red-400 text-xs mt-1">{{ editForm.errors.name }}</div>
                </div>

                <!-- Toggle Aktif/Nonaktif Tenant -->
                <div class="bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-4 py-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-300 font-medium">Status Tenant</p>
                            <p class="text-xs text-gray-600 mt-0.5">Nonaktif = semua akun tenant ini tidak bisa login</p>
                        </div>
                        <!-- Toggle Switch -->
                        <button
                            type="button"
                            @click="editForm.is_active = !editForm.is_active"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors"
                            :class="editForm.is_active ? 'bg-green-500' : 'bg-gray-600'"
                        >
                            <span
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                                :class="editForm.is_active ? 'translate-x-6' : 'translate-x-1'"
                            />
                        </button>
                    </div>
                    <p class="text-xs font-bold mt-2" :class="editForm.is_active ? 'text-green-400' : 'text-red-400'">
                        {{ editForm.is_active ? 'Tenant Aktif — Semua akun bisa login' : 'Tenant Nonaktif — Semua akun diblokir' }}
                    </p>
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
