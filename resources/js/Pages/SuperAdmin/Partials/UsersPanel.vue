<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Navbar from '@/Components/Navbar.vue';

// Props dari SuperAdminController@users
const props = defineProps({
    users: Array,
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

// --- Logika Edit User ---
const showEditModal = ref(false);
const editForm = useForm({
    id:       null,
    name:     '',
    email:    '',
    password: '', // Kosong = tidak diubah
});

const openEdit = (user) => {
    editForm.id       = user.id;
    editForm.name     = user.name;
    editForm.email    = user.email;
    editForm.password = ''; // Selalu kosong saat modal dibuka
    showEditModal.value = true;
};

const submitEdit = () => {
    editForm.put(route('superadmin.users.update', editForm.id), {
        preserveScroll: true,
        onSuccess: () => { showEditModal.value = false; },
    });
};

// --- Helper warna badge role ---
const roleBadgeClass = (role) => {
    const map = {
        owner:       'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
        manager:     'bg-purple-500/10 text-purple-400 border-purple-500/20',
        warehouse:   'bg-blue-500/10 text-blue-400 border-blue-500/20',
        marketing:   'bg-pink-500/10 text-pink-400 border-pink-500/20',
        finance:     'bg-green-500/10 text-green-400 border-green-500/20',
        super_admin: 'bg-red-500/10 text-red-400 border-red-500/20',
    };
    return map[role] ?? 'bg-gray-500/10 text-gray-400 border-gray-500/20';
};
</script>

<template>
    <Head title="Kelola User - OmniTerminal" />

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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </span>
                        Kelola User
                    </h2>
                </div>

                <!-- Tabel Daftar Semua User -->
                <div class="bg-[#121317] border border-[#1f2128] rounded-xl overflow-hidden shadow-lg">
                    <div class="p-5 border-b border-[#1f2128] bg-[#1a1b20]/50 flex justify-between items-center">
                        <h3 class="text-sm font-bold text-white uppercase tracking-wider">Daftar Semua User</h3>
                        <span class="text-xs text-gray-500 font-mono">{{ props.users.length }} Akun</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left">
                            <thead class="bg-[#0a0b0d] text-gray-500 uppercase text-[10px] tracking-wider font-bold">
                                <tr>
                                    <th class="px-5 py-4 border-b border-[#1f2128]">Nama & Email</th>
                                    <th class="px-5 py-4 border-b border-[#1f2128]">Tenant</th>
                                    <th class="px-5 py-4 border-b border-[#1f2128]">Role</th>
                                    <th class="px-5 py-4 border-b border-[#1f2128]">Bergabung</th>
                                    <th class="px-5 py-4 border-b border-[#1f2128] text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#1f2128]">
                                <tr v-for="user in props.users" :key="user.id" class="hover:bg-[#1a1b20]/50 transition-colors">
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-gray-200 text-sm">{{ user.name }}</div>
                                        <div class="text-[10px] text-gray-500">{{ user.email }}</div>
                                    </td>
                                    <td class="px-5 py-4 text-xs text-gray-400 font-bold">
                                        {{ user.tenant ? user.tenant.name : '-' }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="text-[9px] font-bold px-2 py-1 rounded-full border uppercase tracking-wider"
                                            :class="roleBadgeClass(user.role)"
                                        >
                                            {{ user.role }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-xs text-gray-500 font-mono">
                                        {{ new Date(user.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <button @click="openEdit(user)" class="text-yellow-500 hover:text-yellow-400 font-bold text-[10px] uppercase border border-yellow-500/30 px-2 py-1 rounded bg-yellow-500/10 transition-colors">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="props.users.length === 0">
                                    <td colspan="5" class="px-5 py-12 text-center text-gray-600 italic text-sm">
                                        Belum ada user yang terdaftar.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div v-if="showEditModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm">
        <div class="bg-[#121317] border border-[#2d2f36] rounded-xl p-6 w-full max-w-md shadow-2xl">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-6 border-b border-[#1f2128] pb-3">Edit Data User</h3>

            <form @submit.prevent="submitEdit" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <input
                        v-model="editForm.name"
                        type="text"
                        class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]"
                        required
                    >
                    <div v-if="editForm.errors.name" class="text-red-400 text-xs mt-1">{{ editForm.errors.name }}</div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Email</label>
                    <input
                        v-model="editForm.email"
                        type="email"
                        class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]"
                        required
                    >
                    <div v-if="editForm.errors.email" class="text-red-400 text-xs mt-1">{{ editForm.errors.email }}</div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                        Reset Password <span class="normal-case text-gray-600">(kosongkan jika tidak diubah)</span>
                    </label>
                    <input
                        v-model="editForm.password"
                        type="password"
                        class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]"
                        placeholder="••••••••"
                    >
                    <div v-if="editForm.errors.password" class="text-red-400 text-xs mt-1">{{ editForm.errors.password }}</div>
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
