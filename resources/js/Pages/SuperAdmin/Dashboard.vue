<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Navbar from '@/Components/Navbar.vue';

// --- DATA DARI CONTROLLER ---
const props = defineProps({
    tenants: Array,
    users: Array,
});

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

// ==========================================
// LOGIKA EDIT TENANT (TOKO)
// ==========================================
const isEditingTenant = ref(false);
const tenantForm = useForm({
    id: null,
    name: '',
    is_active: false,
});

const openEditTenant = (tenant) => {
    tenantForm.id = tenant.id;
    tenantForm.name = tenant.name;
    // Ubah boolean dari database (1/0) ke tipe boolean js (true/false)
    tenantForm.is_active = tenant.is_active === 1 || tenant.is_active === true; 
    isEditingTenant.value = true;
};

const closeEditTenant = () => {
    isEditingTenant.value = false;
    tenantForm.reset();
};

const submitTenantUpdate = () => {
    tenantForm.put(route('superadmin.tenants.update', tenantForm.id), {
        preserveScroll: true,
        onSuccess: () => closeEditTenant(),
    });
};

// ==========================================
// LOGIKA EDIT DATA LOGIN USER
// ==========================================
const isEditingUser = ref(false);
const userForm = useForm({
    id: null,
    name: '',
    email: '',
    password: '', // Kosongkan, hanya diisi jika ingin mereset password
});

const openEditUser = (user) => {
    userForm.id = user.id;
    userForm.name = user.name;
    userForm.email = user.email;
    userForm.password = ''; // Pastikan selalu kosong saat dibuka
    isEditingUser.value = true;
};

const closeEditUser = () => {
    isEditingUser.value = false;
    userForm.reset();
};

const submitUserUpdate = () => {
    userForm.put(route('superadmin.users.update', userForm.id), {
        preserveScroll: true,
        onSuccess: () => closeEditUser(),
    });
};
</script>

<template>
    <Head title="Super Admin Center - OmniTerminal" />

    <div class="min-h-screen bg-[#0a0b0d] text-gray-300 font-sans relative">
        <Sidebar :is-collapsed="isSidebarCollapsed" @toggle="toggleSidebar" />

        <div class="transition-all duration-300 ease-in-out min-h-screen flex flex-col" :class="isSidebarCollapsed ? 'ml-[72px]' : 'ml-64'">
            <Navbar />

            <main class="p-6 lg:p-8 space-y-8 flex-1 pb-20">
                
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white tracking-wide flex items-center gap-2">
                        <span class="p-1.5 rounded bg-gradient-to-br from-[#f43f5e] to-[#be123c] text-white shadow-[0_0_15px_rgba(244,63,94,0.4)]">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </span>
                        Super Admin Control Center
                    </h2>
                    <span class="bg-[#1a1b20] border border-red-900/50 text-red-400 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">
                        God Mode
                    </span>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                    
                    <div class="bg-[#121317] border border-[#1f2128] rounded-xl overflow-hidden shadow-lg flex flex-col h-[500px]">
                        <div class="p-5 border-b border-[#1f2128] bg-[#1a1b20]/50 flex justify-between items-center">
                            <h3 class="text-sm font-bold text-white uppercase tracking-wider">Daftar Klien (Tenants)</h3>
                            <span class="text-xs text-gray-500 font-mono">{{ props.tenants.length }} Klien</span>
                        </div>
                        <div class="overflow-y-auto flex-1 custom-scrollbar">
                            <table class="min-w-full text-left">
                                <thead class="bg-[#0a0b0d] text-gray-500 uppercase text-[10px] tracking-wider font-bold sticky top-0 z-10">
                                    <tr>
                                        <th class="px-5 py-4 border-b border-[#1f2128]">Nama Toko</th>
                                        <th class="px-5 py-4 border-b border-[#1f2128]">Status</th>
                                        <th class="px-5 py-4 border-b border-[#1f2128]">Total Akun</th>
                                        <th class="px-5 py-4 border-b border-[#1f2128] text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#1f2128]">
                                    <tr v-for="tenant in props.tenants" :key="tenant.id" class="hover:bg-[#1a1b20]/50 transition-colors group">
                                        <td class="px-5 py-4 font-bold text-gray-200 text-sm">{{ tenant.name }}</td>
                                        <td class="px-5 py-4">
                                            <span class="text-[9px] font-bold px-2 py-1 rounded border uppercase" 
                                                  :class="tenant.is_active ? 'bg-green-500/10 text-green-400 border-green-500/20' : 'bg-red-500/10 text-red-400 border-red-500/20'">
                                                {{ tenant.is_active ? 'Aktif' : 'Dibekukan' }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-xs text-gray-400">{{ tenant.users_count }} Karyawan</td>
                                        <td class="px-5 py-4 text-right">
                                            <button @click="openEditTenant(tenant)" class="text-blue-500 hover:text-blue-400 font-bold text-[10px] uppercase border border-blue-500/30 px-2 py-1 rounded bg-blue-500/10 transition-colors">Edit</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-[#121317] border border-[#1f2128] rounded-xl overflow-hidden shadow-lg flex flex-col h-[500px]">
                        <div class="p-5 border-b border-[#1f2128] bg-[#1a1b20]/50 flex justify-between items-center">
                            <h3 class="text-sm font-bold text-white uppercase tracking-wider">Data Login Users</h3>
                            <span class="text-xs text-gray-500 font-mono">{{ props.users.length }} Akun</span>
                        </div>
                        <div class="overflow-y-auto flex-1 custom-scrollbar">
                            <table class="min-w-full text-left">
                                <thead class="bg-[#0a0b0d] text-gray-500 uppercase text-[10px] tracking-wider font-bold sticky top-0 z-10">
                                    <tr>
                                        <th class="px-5 py-4 border-b border-[#1f2128]">Pengguna</th>
                                        <th class="px-5 py-4 border-b border-[#1f2128]">Toko (Tenant)</th>
                                        <th class="px-5 py-4 border-b border-[#1f2128]">Role</th>
                                        <th class="px-5 py-4 border-b border-[#1f2128] text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#1f2128]">
                                    <tr v-for="user in props.users" :key="user.id" class="hover:bg-[#1a1b20]/50 transition-colors group">
                                        <td class="px-5 py-4">
                                            <div class="font-bold text-gray-200 text-sm">{{ user.name }}</div>
                                            <div class="text-[10px] text-gray-500">{{ user.email }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-xs font-bold text-gray-400">{{ user.tenant ? user.tenant.name : '-' }}</td>
                                        <td class="px-5 py-4">
                                            <span class="text-[9px] font-bold text-purple-400 uppercase tracking-wider">{{ user.role }}</span>
                                        </td>
                                        <td class="px-5 py-4 text-right">
                                            <button @click="openEditUser(user)" class="text-yellow-500 hover:text-yellow-400 font-bold text-[10px] uppercase border border-yellow-500/30 px-2 py-1 rounded bg-yellow-500/10 transition-colors">Edit</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </main>
        </div>
    </div>

    <div v-if="isEditingTenant" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 animate-fade-in">
        <div class="bg-[#121317] border border-[#2d2f36] rounded-xl p-6 w-full max-w-md shadow-2xl relative">
            <h3 class="text-lg font-bold text-white mb-4">Edit Klien (Tenant)</h3>
            
            <form @submit.prevent="submitTenantUpdate" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Toko</label>
                    <input v-model="tenantForm.name" type="text" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]" required>
                    <div v-if="tenantForm.errors.name" class="text-red-500 text-xs mt-1">{{ tenantForm.errors.name }}</div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <input v-model="tenantForm.is_active" type="checkbox" id="status_active" class="w-4 h-4 rounded bg-[#0a0b0d] border-[#2d2f36] text-[#8c52ff] focus:ring-[#8c52ff] focus:ring-offset-gray-900">
                    <label for="status_active" class="text-sm text-gray-300 font-medium cursor-pointer">Toko Aktif (Bisa Login)</label>
                </div>
                <p class="text-[10px] text-gray-500">Hapus centang untuk membekukan toko ini (misal: belum bayar tagihan).</p>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-[#1f2128]">
                    <button type="button" @click="closeEditTenant" class="px-4 py-2 rounded text-xs font-bold text-gray-400 hover:text-white transition-colors">Batal</button>
                    <button type="submit" :disabled="tenantForm.processing" class="px-4 py-2 rounded text-xs font-bold bg-[#8c52ff] hover:bg-[#7b42ea] text-white transition-colors disabled:opacity-50">
                        {{ tenantForm.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div v-if="isEditingUser" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 animate-fade-in">
        <div class="bg-[#121317] border border-[#2d2f36] rounded-xl p-6 w-full max-w-md shadow-2xl relative">
            <h3 class="text-lg font-bold text-white mb-4">Edit Data Login User</h3>
            
            <form @submit.prevent="submitUserUpdate" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Lengkap</label>
                    <input v-model="userForm.name" type="text" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:border-[#8c52ff]" required>
                    <div v-if="userForm.errors.name" class="text-red-500 text-xs mt-1">{{ userForm.errors.name }}</div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Alamat Email (Untuk Login)</label>
                    <input v-model="userForm.email" type="email" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:border-[#8c52ff]" required>
                    <div v-if="userForm.errors.email" class="text-red-500 text-xs mt-1">{{ userForm.errors.email }}</div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Reset Password Baru</label>
                    <input v-model="userForm.password" type="password" class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2 text-sm text-gray-300 focus:border-[#8c52ff]" placeholder="Kosongkan jika tidak ingin diubah">
                    <p class="text-[10px] text-gray-500 mt-1">Jika diisi, user akan menggunakan password baru ini untuk login berikutnya.</p>
                    <div v-if="userForm.errors.password" class="text-red-500 text-xs mt-1">{{ userForm.errors.password }}</div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-[#1f2128]">
                    <button type="button" @click="closeEditUser" class="px-4 py-2 rounded text-xs font-bold text-gray-400 hover:text-white transition-colors">Batal</button>
                    <button type="submit" :disabled="userForm.processing" class="px-4 py-2 rounded text-xs font-bold bg-yellow-500 hover:bg-yellow-600 text-black transition-colors disabled:opacity-50">
                        {{ userForm.processing ? 'Menyimpan...' : 'Update Login User' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
/* Animasi muncul untuk Modal */
@keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
.animate-fade-in { animation: fadeIn 0.2s ease-out forwards; }

/* Scrollbar khusus untuk tabel di dalam dashboard */
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
</style>