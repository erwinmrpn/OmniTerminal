<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Navbar from '@/Components/Navbar.vue';

// Props yang dikirim dari StaffController (Daftar Staf)
const props = defineProps({
    staffs: Array
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

// Form Logic (Untuk Tambah Staf Baru)
const form = useForm({
    name: '',
    email: '',
    password: '',
    role: 'warehouse', // Default role yang dipilih
});

const submit = () => {
    form.post(route('owner.staff.store'), {
        onSuccess: () => form.reset(),
    });
};

// --- Logika Hapus Staf ---
const deleteStaff = (id, name) => {
    if (!confirm(`Hapus staf "${name}"? Tindakan ini tidak bisa dibatalkan.`)) return;
    router.delete(route('owner.staff.destroy', id));
};

// --- Logika Edit Staf ---
const showEditModal = ref(false);
const editForm = useForm({
    id: null,
    name: '',
    email: '',
    role: 'warehouse',
});

const openEdit = (staff) => {
    editForm.id    = staff.id;
    editForm.name  = staff.name;
    editForm.email = staff.email;
    editForm.role  = staff.role;
    showEditModal.value = true;
};

const submitEdit = () => {
    editForm.put(route('owner.staff.update', editForm.id), {
        onSuccess: () => { showEditModal.value = false; },
    });
};
</script>

<template>
    <Head title="Manajemen Staf - OmniTerminal" />

    <div class="min-h-screen bg-[#0a0b0d] text-gray-300 font-sans relative">
        <Sidebar :is-collapsed="isSidebarCollapsed" @toggle="toggleSidebar" />

        <div class="transition-all duration-300 ease-in-out min-h-screen flex flex-col" :class="isSidebarCollapsed ? 'ml-[72px]' : 'ml-64'">
            <Navbar />

            <main class="p-6 lg:p-8 flex-1 pb-20">
                
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-xl font-bold text-white tracking-wide flex items-center gap-2">
                        <span class="p-1.5 rounded bg-gradient-to-br from-[#8c52ff] to-[#5ce1e6] text-white">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </span>
                        Manajemen Tim & Karyawan
                    </h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <div class="lg:col-span-1">
                        <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-6 shadow-lg">
                            <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-6 border-b border-[#1f2128] pb-3">Tambah Staf Baru</h3>
                            
                            <form @submit.prevent="submit" class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                                    <input v-model="form.name" type="text" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" placeholder="Misal: Budi Santoso" required>
                                    <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Alamat Email</label>
                                    <input v-model="form.email" type="email" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" placeholder="budi@toko.com" required>
                                    <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Password Sementara</label>
                                    <input v-model="form.password" type="password" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" placeholder="Min. 8 karakter" required>
                                    <div v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pilih Role Akses</label>
                                    <select v-model="form.role" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff] appearance-none" required>
                                        <option value="manager">Manager Operasional</option>
                                        <option value="warehouse">Admin Gudang (WMS)</option>
                                        <option value="marketing">Media Buyer / Marketing</option>
                                        <option value="finance">Admin Finance / Keuangan</option>
                                    </select>
                                    <div v-if="form.errors.role" class="text-red-500 text-xs mt-1">{{ form.errors.role }}</div>
                                </div>

                                <button type="submit" :disabled="form.processing" class="w-full mt-6 bg-gradient-to-r from-[#8c52ff] to-[#5e17eb] hover:from-[#7b42ea] hover:to-[#4a0dd6] text-white font-bold py-2.5 rounded-md text-sm transition-all disabled:opacity-50">
                                    {{ form.processing ? 'Menyimpan...' : 'Simpan Karyawan' }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="bg-[#121317] border border-[#1f2128] rounded-xl overflow-hidden shadow-lg h-full flex flex-col">
                            <div class="p-6 border-b border-[#1f2128] bg-[#1a1b20]/50">
                                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Daftar Karyawan Aktif</h3>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-left">
                                    <thead class="bg-[#0a0b0d] text-gray-500 uppercase text-[10px] tracking-wider font-bold">
                                        <tr>
                                            <th class="px-6 py-4 border-b border-[#1f2128]">Nama & Email</th>
                                            <th class="px-6 py-4 border-b border-[#1f2128]">Role Akses</th>
                                            <th class="px-6 py-4 border-b border-[#1f2128]">Tgl Bergabung</th>
                                            <th class="px-6 py-4 border-b border-[#1f2128] text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#1f2128]">
                                        <tr v-for="staff in props.staffs" :key="staff.id" class="hover:bg-[#1a1b20]/50 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-gray-200 text-sm">{{ staff.name }}</div>
                                                <div class="text-xs text-gray-500">{{ staff.email }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider border"
                                                    :class="{
                                                        'bg-purple-500/10 text-purple-400 border-purple-500/20': staff.role === 'manager',
                                                        'bg-blue-500/10 text-blue-400 border-blue-500/20': staff.role === 'warehouse',
                                                        'bg-pink-500/10 text-pink-400 border-pink-500/20': staff.role === 'marketing',
                                                        'bg-green-500/10 text-green-400 border-green-500/20': staff.role === 'finance',
                                                    }"
                                                >
                                                    {{ staff.role }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-xs text-gray-400 font-mono">
                                                {{ new Date(staff.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <!-- Tombol Edit -->
                                                <button @click="openEdit(staff)" class="text-gray-500 hover:text-blue-400 transition-colors mr-3" title="Edit Staf">
                                                    <svg class="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                                </button>
                                                <!-- Tombol Hapus -->
                                                <button @click="deleteStaff(staff.id, staff.name)" class="text-gray-500 hover:text-red-400 transition-colors" title="Hapus Staf">
                                                    <svg class="w-5 h-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr v-if="props.staffs.length === 0">
                                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic text-sm">
                                                Belum ada staf yang terdaftar di sistem.
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

    <!-- Modal Edit Staf -->
    <div v-if="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">
        <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-6 w-full max-w-md shadow-xl">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-6 border-b border-[#1f2128] pb-3">Edit Data Staf</h3>

            <form @submit.prevent="submitEdit" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <input v-model="editForm.name" type="text" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" required>
                    <div v-if="editForm.errors.name" class="text-red-500 text-xs mt-1">{{ editForm.errors.name }}</div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Alamat Email</label>
                    <input v-model="editForm.email" type="email" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" required>
                    <div v-if="editForm.errors.email" class="text-red-500 text-xs mt-1">{{ editForm.errors.email }}</div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Role Akses</label>
                    <select v-model="editForm.role" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff] appearance-none" required>
                        <option value="manager">Manager Operasional</option>
                        <option value="warehouse">Admin Gudang (WMS)</option>
                        <option value="marketing">Media Buyer / Marketing</option>
                        <option value="finance">Admin Finance / Keuangan</option>
                    </select>
                    <div v-if="editForm.errors.role" class="text-red-500 text-xs mt-1">{{ editForm.errors.role }}</div>
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