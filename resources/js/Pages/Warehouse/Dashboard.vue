<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import Navbar from '@/Components/Navbar.vue';

// --- DATA DARI CONTROLLER (Props) ---
// Note: Props ini nantinya akan dikirim dari WarehouseController
const props = defineProps({
    summary: {
        type: Object,
        default: () => ({ READY_TO_PACK: 0, PACKED: 0, READY_TO_SHIP: 0, CANCELED: 0 })
    },
    low_stock: {
        type: Array,
        default: () => []
    },
    active_tasks: {
        type: Array,
        default: () => []
    },
    order_history: {
        type: Array,
        default: () => []
    },
    flash: Object // Untuk menangkap pesan dari session (refresh_message, scan_message)
});

// --- STATE SIDEBAR ADAPTIF ---
const isSidebarCollapsed = ref(false);
const toggleSidebar = () => {
    isSidebarCollapsed.value = !isSidebarCollapsed.value;
    localStorage.setItem("sidebar_collapsed", String(isSidebarCollapsed.value));
}

// --- LOGIKA STASIUN SCAN TERPUSAT ---
const barcodeInput = ref(null); // Reference ke elemen input barcode
const scanForm = useForm({
    barcode: '',
});

const submitScan = () => {
    // Nantinya ini menembak route khusus scan, misal: route('warehouse.scan')
    scanForm.post('/warehouse/scan', {
        preserveScroll: true,
        onFinish: () => {
            scanForm.reset('barcode');
            // Kembalikan fokus ke input setelah scan (seperti script lama Anda)
            if (barcodeInput.value) {
                setTimeout(() => barcodeInput.value.focus(), 50);
            }
        }
    });
};

// --- LOGIKA AKORDION (Tugas & History) ---
const isTasksOpen = ref(false);
const isHistoryOpen = ref(false);

const toggleTasks = () => isTasksOpen.value = !isTasksOpen.value;
const toggleHistory = () => isHistoryOpen.value = !isHistoryOpen.value;

// --- HELPER WARNA BADGE (Adaptasi dari function badge() PHP) ---
const getBadgeClass = (status) => {
    const map = {
        'READY_TO_PACK': 'bg-blue-500/10 text-blue-400 border-blue-500/20',
        'PACKED': 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
        'READY_TO_SHIP': 'bg-green-500/10 text-green-400 border-green-500/20',
        'CANCELED': 'bg-purple-500/10 text-purple-400 border-purple-500/20',
        'COMPLETED': 'bg-green-500/10 text-green-400 border-green-500/20',
        'UNKNOWN': 'bg-gray-500/10 text-gray-400 border-gray-500/20'
    };
    return map[status] || map['UNKNOWN'];
};

// --- LIFECYCLE HOOKS ---
onMounted(() => {
    const savedSidebar = localStorage.getItem("sidebar_collapsed");
    if (savedSidebar === "true") isSidebarCollapsed.value = true;

    // Auto-focus barcode saat halaman dimuat
    if (barcodeInput.value) barcodeInput.value.focus();
});
</script>

<template>
    <Head title="WMS Dashboard - OmniTerminal" />

    <div class="min-h-screen bg-[#0a0b0d] text-gray-300 font-sans relative">
        <Sidebar :is-collapsed="isSidebarCollapsed" @toggle="toggleSidebar" />

        <div class="transition-all duration-300 ease-in-out min-h-screen flex flex-col" :class="isSidebarCollapsed ? 'ml-[72px]' : 'ml-64'">
            <Navbar />

            <main class="p-6 lg:p-8 space-y-6 flex-1 pb-20">
                
                <div v-if="$page.props.flash && $page.props.flash.success" class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg font-bold">
                    {{ $page.props.flash.success }}
                </div>
                <div v-if="$page.props.flash && $page.props.flash.error" class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg font-bold">
                    {{ $page.props.flash.error }}
                </div>

                <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-8 shadow-lg text-center relative overflow-hidden">
                    <div class="absolute -top-[50px] -left-[50px] w-[150px] h-[150px] bg-[#8c52ff] rounded-full blur-[80px] opacity-10 pointer-events-none"></div>
                    
                    <h2 class="text-2xl font-black text-white mb-6 flex items-center justify-center gap-3">
                        <span class="text-3xl">🚚</span> Stasiun Scan Terpusat
                    </h2>
                    
                    <form @submit.prevent="submitScan" class="max-w-xl mx-auto">
                        <input 
                            ref="barcodeInput"
                            v-model="scanForm.barcode" 
                            type="text" 
                            class="w-full bg-[#1a1b20] border-2 border-[#2d2f36] focus:border-[#8c52ff] rounded-xl px-6 py-4 text-xl text-center text-white font-mono tracking-widest placeholder-gray-600 transition-colors shadow-inner"
                            placeholder="SCAN RESI APAPUN DI SINI"
                            required
                        >
                    </form>

                    <div v-if="$page.props.flash && $page.props.flash.scan_message" 
                         class="mt-6 inline-block px-6 py-3 rounded-lg font-bold border"
                         :class="{
                             'bg-green-500/10 text-green-400 border-green-500/30': $page.props.flash.scan_type === 'success',
                             'bg-red-500/10 text-red-400 border-red-500/30': $page.props.flash.scan_type === 'error',
                             'bg-yellow-500/10 text-yellow-400 border-yellow-500/30': $page.props.flash.scan_type === 'warn',
                         }">
                        {{ $page.props.flash.scan_message }}
                    </div>
                </div>

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mt-4">
                    <div>
                        <h2 class="text-xl font-bold text-white flex items-center gap-2">📦 WMS Dashboard</h2>
                        <div class="text-sm text-gray-500 mt-1">Ringkasan operasional 7 hari terakhir</div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mt-4 md:mt-0">
                        <Link href="#" class="px-4 py-2 bg-yellow-500/10 border border-yellow-500/30 rounded-lg text-xs font-bold text-yellow-500 hover:bg-yellow-500/20 transition-all">🔄 Refresh Token Lazada</Link>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-6 shadow-sm flex flex-col items-center justify-center group hover:border-[#8c52ff] transition-colors">
                        <div class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Ready To Pack</div>
                        <h2 class="text-3xl font-black text-blue-400 group-hover:scale-110 transition-transform">{{ props.summary.READY_TO_PACK }}</h2>
                    </div>
                    <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-6 shadow-sm flex flex-col items-center justify-center group hover:border-yellow-500 transition-colors">
                        <div class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Packed</div>
                        <h2 class="text-3xl font-black text-yellow-400 group-hover:scale-110 transition-transform">{{ props.summary.PACKED }}</h2>
                    </div>
                    <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-6 shadow-sm flex flex-col items-center justify-center group hover:border-green-500 transition-colors">
                        <div class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Ready To Ship</div>
                        <h2 class="text-3xl font-black text-green-400 group-hover:scale-110 transition-transform">{{ props.summary.READY_TO_SHIP }}</h2>
                    </div>
                    <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-6 shadow-sm flex flex-col items-center justify-center group hover:border-purple-500 transition-colors">
                        <div class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Canceled</div>
                        <h2 class="text-3xl font-black text-purple-400 group-hover:scale-110 transition-transform">{{ props.summary.CANCELED }}</h2>
                    </div>
                </div>

                <div class="bg-[#121317] border border-red-900/30 rounded-xl overflow-hidden shadow-lg">
                    <div class="p-5 border-b border-red-900/20 bg-red-900/10">
                        <h3 class="text-sm font-bold text-red-400 uppercase tracking-wider flex items-center gap-2">📉 Stok Menipis</h3>
                    </div>
                    
                    <div v-if="props.low_stock.length === 0" class="p-8 text-center text-gray-500 italic text-sm">
                        Semua stok dalam keadaan aman 🎉
                    </div>
                    
                    <div v-else class="overflow-x-auto">
                        <table class="min-w-full text-left">
                            <thead class="bg-[#0a0b0d] text-gray-500 uppercase text-[10px] tracking-wider font-bold">
                                <tr>
                                    <th class="px-6 py-3 border-b border-[#1f2128]">SKU</th>
                                    <th class="px-6 py-3 border-b border-[#1f2128]">Nama Produk</th>
                                    <th class="px-6 py-3 border-b border-[#1f2128] text-right">Sisa Stok</th>
                                    <th class="px-6 py-3 border-b border-[#1f2128] text-right">Batas Min.</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#1f2128]">
                                <tr v-for="item in props.low_stock" :key="item.channel_sku" class="hover:bg-[#1a1b20]/50 transition-colors">
                                    <td class="px-6 py-4 font-mono text-xs text-gray-400">{{ item.channel_sku }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-200 text-sm">{{ item.name }}</td>
                                    <td class="px-6 py-4 text-right font-black text-red-400">{{ item.stock_on_hand }}</td>
                                    <td class="px-6 py-4 text-right text-xs text-gray-500">{{ item.threshold_min }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="bg-[#121317] border border-[#1f2128] rounded-xl overflow-hidden shadow-lg">
                        <div @click="toggleTasks" class="p-5 border-b border-[#1f2128] bg-[#1a1b20]/50 flex justify-between items-center cursor-pointer hover:bg-[#1f2128] transition-colors">
                            <h3 class="text-sm font-bold text-white uppercase tracking-wider">🧾 10 Tugas Packing Aktif</h3>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="{'rotate-180': isTasksOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                        
                        <div v-if="props.active_tasks.length === 0" class="p-6 text-center text-gray-500 text-xs">
                            Tidak ada tugas aktif saat ini.
                        </div>
                        
                        <div v-else>
                            <div class="px-6 py-4 border-b border-[#1f2128] flex justify-between items-center bg-[#0a0b0d]">
                                <div class="font-bold text-white text-sm">{{ props.active_tasks[0]?.order_number }}</div>
                                <span class="text-[9px] font-bold px-2 py-1 rounded border uppercase" :class="getBadgeClass(props.active_tasks[0]?.status)">
                                    {{ props.active_tasks[0]?.status.replace(/_/g, ' ') }}
                                </span>
                            </div>
                            
                            <div v-show="isTasksOpen" class="divide-y divide-[#1f2128]">
                                <div v-for="(task, index) in props.active_tasks.slice(1)" :key="index" class="px-6 py-3 flex justify-between items-center hover:bg-[#1a1b20]/50 transition-colors">
                                    <div>
                                        <div class="font-bold text-gray-300 text-sm">{{ task.order_number }}</div>
                                        <div class="text-[10px] font-mono text-gray-500">{{ task.tracking_number }}</div>
                                    </div>
                                    <span class="text-[9px] font-bold px-2 py-1 rounded border uppercase" :class="getBadgeClass(task.status)">
                                        {{ task.status.replace(/_/g, ' ') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#121317] border border-[#1f2128] rounded-xl overflow-hidden shadow-lg">
                        <div @click="toggleHistory" class="p-5 border-b border-[#1f2128] bg-[#1a1b20]/50 flex justify-between items-center cursor-pointer hover:bg-[#1f2128] transition-colors">
                            <h3 class="text-sm font-bold text-white uppercase tracking-wider">📜 10 Order Terakhir (History)</h3>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="{'rotate-180': isHistoryOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                        
                        <div v-if="props.order_history.length === 0" class="p-6 text-center text-gray-500 text-xs">
                            Belum ada histori order.
                        </div>
                        
                        <div v-else>
                            <div class="px-6 py-4 border-b border-[#1f2128] flex justify-between items-center bg-[#0a0b0d]">
                                <div class="font-bold text-white text-sm">{{ props.order_history[0]?.order_number }}</div>
                                <span class="text-[9px] font-bold px-2 py-1 rounded border uppercase" :class="getBadgeClass(props.order_history[0]?.outcome)">
                                    {{ props.order_history[0]?.outcome.replace(/_/g, ' ') }}
                                </span>
                            </div>
                            
                            <div v-show="isHistoryOpen" class="divide-y divide-[#1f2128]">
                                <div v-for="(hist, index) in props.order_history.slice(1)" :key="index" class="px-6 py-3 flex justify-between items-center hover:bg-[#1a1b20]/50 transition-colors">
                                    <div>
                                        <div class="font-bold text-gray-300 text-sm">{{ hist.order_number }}</div>
                                        <div class="text-[10px] font-mono text-gray-500">{{ hist.tracking_number }}</div>
                                    </div>
                                    <span class="text-[9px] font-bold px-2 py-1 rounded border uppercase" :class="getBadgeClass(hist.outcome)">
                                        {{ hist.outcome.replace(/_/g, ' ') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</template>

<style scoped>
/* Transisi mulus untuk akordion */
.v-enter-active,
.v-leave-active {
  transition: opacity 0.3s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>