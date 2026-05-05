<script setup>
import { ref, onMounted } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Navbar from '@/Components/Navbar.vue';

const props = defineProps({
    consultations: Array,
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

// Detail Modal
const showDetail = ref(false);
const selectedConsultation = ref(null);

const openDetail = (consultation) => {
    selectedConsultation.value = consultation;
    showDetail.value = true;
};

// Hapus
const deleteConsultation = (id, name) => {
    if (!confirm(`Delete consultation from "${name}"?`)) return;
    router.delete(route('superadmin.consultations.destroy', id));
};
</script>

<template>
    <Head title="Consultations - OmniTerminal" />

    <div class="min-h-screen bg-[#0a0b0d] text-gray-300 font-sans relative">
        <Sidebar :is-collapsed="isSidebarCollapsed" @toggle="toggleSidebar" />

        <div class="transition-all duration-300 ease-in-out min-h-screen flex flex-col" :class="isSidebarCollapsed ? 'ml-[72px]' : 'ml-64'">
            <Navbar />

            <main class="p-6 lg:p-8 flex-1 pb-20">

                <!-- Header -->
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-xl font-bold text-white tracking-wide flex items-center gap-2">
                        <span class="p-1.5 rounded bg-gradient-to-br from-[#f43f5e] to-[#be123c] text-white">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </span>
                        Consultations
                    </h2>
                    <span class="text-xs text-gray-500 font-mono">{{ props.consultations.length }} Submissions</span>
                </div>

                <!-- Tabel -->
                <div class="bg-[#121317] border border-[#1f2128] rounded-xl overflow-hidden shadow-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left">
                            <thead class="bg-[#0a0b0d] text-gray-500 uppercase text-[10px] tracking-wider font-bold">
                                <tr>
                                    <th class="px-5 py-4 border-b border-[#1f2128]">Name</th>
                                    <th class="px-5 py-4 border-b border-[#1f2128]">Business</th>
                                    <th class="px-5 py-4 border-b border-[#1f2128]">WhatsApp</th>
                                    <th class="px-5 py-4 border-b border-[#1f2128]">Email</th>
                                    <th class="px-5 py-4 border-b border-[#1f2128]">Date</th>
                                    <th class="px-5 py-4 border-b border-[#1f2128] text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#1f2128]">
                                <tr v-for="item in props.consultations" :key="item.id" class="hover:bg-[#1a1b20]/50 transition-colors">
                                    <td class="px-5 py-4 font-bold text-gray-200 text-sm">{{ item.name }}</td>
                                    <td class="px-5 py-4 text-xs text-gray-400">{{ item.business }}</td>
                                    <td class="px-5 py-4 text-xs text-gray-400 font-mono">{{ item.whatsapp }}</td>
                                    <td class="px-5 py-4 text-xs text-gray-400">{{ item.email }}</td>
                                    <td class="px-5 py-4 text-xs text-gray-500 font-mono">
                                        {{ new Date(item.created_at).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) }}
                                    </td>
                                    <td class="px-5 py-4 text-right flex justify-end gap-2">
                                        <button @click="openDetail(item)" class="text-blue-500 hover:text-blue-400 font-bold text-[10px] uppercase border border-blue-500/30 px-2 py-1 rounded bg-blue-500/10 transition-colors">
                                            View
                                        </button>
                                        <button @click="deleteConsultation(item.id, item.name)" class="text-red-500 hover:text-red-400 font-bold text-[10px] uppercase border border-red-500/30 px-2 py-1 rounded bg-red-500/10 transition-colors">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="props.consultations.length === 0">
                                    <td colspan="6" class="px-5 py-12 text-center text-gray-600 italic text-sm">
                                        No consultation submissions yet.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Detail -->
    <div v-if="showDetail && selectedConsultation" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm">
        <div class="bg-[#121317] border border-[#2d2f36] rounded-xl p-6 w-full max-w-lg shadow-2xl">
            <div class="flex justify-between items-center mb-6 border-b border-[#1f2128] pb-3">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider">Consultation Detail</h3>
                <button @click="showDetail = false" class="text-gray-500 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="space-y-4">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Full Name</p>
                    <p class="text-sm text-gray-200 font-bold">{{ selectedConsultation.name }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Business</p>
                    <p class="text-sm text-gray-200">{{ selectedConsultation.business }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">WhatsApp</p>
                        <p class="text-sm text-gray-200 font-mono">{{ selectedConsultation.whatsapp }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Email</p>
                        <p class="text-sm text-gray-200">{{ selectedConsultation.email }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Message</p>
                    <p class="text-sm text-gray-400 leading-relaxed bg-[#0a0b0d] border border-[#2d2f36] rounded-lg p-3">{{ selectedConsultation.message }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Submitted At</p>
                    <p class="text-xs text-gray-500 font-mono">{{ new Date(selectedConsultation.created_at).toLocaleString('en-GB') }}</p>
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-4 border-t border-[#1f2128]">
                <button @click="showDetail = false" class="flex-1 bg-[#1f2128] hover:bg-[#2d2f36] text-gray-300 font-bold py-2.5 rounded-md text-sm transition-all">
                    Close
                </button>
                <button @click="deleteConsultation(selectedConsultation.id, selectedConsultation.name); showDetail = false" class="flex-1 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 text-red-400 font-bold py-2.5 rounded-md text-sm transition-all">
                    Delete
                </button>
            </div>
        </div>
    </div>
</template>