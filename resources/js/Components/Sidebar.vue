<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

// Menerima status collapse dari Layout utama
const props = defineProps({
    isCollapsed: Boolean,
});

// Mengirim sinyal klik tombol ke Layout utama
const emit = defineEmits(['toggle']);

// Ambil data user saat ini untuk mengecek rolenya
const page = usePage();
const userRole = computed(() => page.props.auth.user.role);

// Master Data Menu beserta akses Role-nya
const allMenuItems = [
    // Dashboard (Beda role, beda rute tujuan)
    { name: 'Dashboard', route: 'superadmin.dashboard', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', roles: ['super_admin'] },
    { name: 'Dashboard', route: 'owner.dashboard', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', roles: ['owner'] },
    { name: 'Dashboard', route: 'manager.dashboard', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', roles: ['manager'] },
    { name: 'WMS Dashboard', route: 'warehouse.dashboard', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', roles: ['warehouse'] },
    { name: 'Ads Dashboard', route: 'marketing.dashboard', icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', roles: ['marketing'] },
    
    // Finance
    { name: 'Finance Dashboard', route: 'finance.dashboard', icon: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', roles: ['finance'] },
    
    // ---------------------------------------------------------
    // FITUR OPERASIONAL GUDANG (WMS)
    // ---------------------------------------------------------
    { name: 'Orders', route: 'warehouse.orders', icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', roles: ['owner', 'manager', 'warehouse'] },
    { name: 'Produk', route: 'products.index', icon: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', roles: ['owner', 'manager', 'warehouse'] },
    { name: 'Stok Gudang', route: 'warehouse.stock', icon: 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4', roles: ['owner', 'manager', 'warehouse'] },
    { name: 'History Order', route: 'warehouse.history', icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', roles: ['owner', 'manager', 'warehouse'] },

    // Fitur Owner
    { name: 'Manajemen Staf', route: 'owner.staff.index', icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', roles: ['owner', 'manager'] },
    { name: 'Integrasi API', route: 'owner.integrations', icon: 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1', roles: ['owner'] },
    
    // Khusus Super Admin
    { name: 'Kelola Tenant', route: 'superadmin.tenants.index', icon: 'M19 21H5a2 2 0 01-2-2V7a2 2 0 012-2h4l2-3h4l2 3h4a2 2 0 012 2v12a2 2 0 01-2 2zM9 17v-2m3 2v-4m3 4v-6M3 7h18', roles: ['super_admin'] },
    { name: 'Kelola User', route: 'superadmin.users.index', icon: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', roles: ['super_admin'] },
];

// Otomatis filter menu yang hanya boleh dilihat oleh Role user saat ini
const menuItems = computed(() => {
    return allMenuItems.filter(item => item.roles.includes(userRole.value));
});
</script>

<template>
    <aside
        class="fixed left-0 top-0 h-screen bg-[#0a0b0d] border-r border-[#1f2128] flex flex-col z-50 transition-all duration-300 ease-in-out"
        :class="props.isCollapsed ? 'w-[72px]' : 'w-64'"
    >
        <div class="h-16 flex items-center relative flex-shrink-0 transition-all duration-300"
             :class="props.isCollapsed ? 'px-0.5 justify-center' : 'px-4 justify-between'">
            
            <div class="flex items-center overflow-hidden transition-all duration-300"
                 :class="props.isCollapsed ? 'gap-1' : 'gap-3'">
                
                <img src="/image/logo_nobg.png" 
                     class="w-8 h-8 min-w-[32px] min-h-[32px] rounded object-contain flex-shrink-0" 
                     alt="OmniTerminal Logo" />
                
                <span 
                    class="font-bold text-gray-100 text-lg tracking-wide whitespace-nowrap transition-all duration-200 origin-left"
                    :class="props.isCollapsed ? 'w-0 opacity-0 hidden' : 'w-auto opacity-100 block'"
                >
                    OmniTerminal
                </span>
            </div>

            <button
                @click="emit('toggle')"
                class="w-8 h-8 min-w-[32px] min-h-[32px] flex items-center justify-center p-0 rounded-md text-gray-400 hover:text-white hover:bg-[#1a1b20] transition-colors cursor-pointer flex-shrink-0"
                :title="props.isCollapsed ? 'Expand sidebar' : 'Close sidebar'"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <rect x="4" y="4" width="16" height="16" rx="2" stroke-width="2" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 4v16" />
                </svg>
            </button>
        </div>

        <nav class="flex-1 py-6 px-2 space-y-1 overflow-y-auto overflow-x-hidden">
            <template v-for="item in menuItems" :key="item.name">
                <Link
                    :href="route(item.route)"
                    class="group flex items-center px-3 py-2.5 rounded-lg transition-all duration-200 whitespace-nowrap"
                    :class="route().current(item.route)
                        ? 'bg-[#1a1b20] text-blue-500'
                        : 'text-gray-500 hover:text-gray-200 hover:bg-[#1a1b20]'"
                    :title="props.isCollapsed ? item.name : ''"
                >
                    <svg class="w-6 h-6 flex-shrink-0 transition-colors duration-200"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon" />
                    </svg>

                    <span
                        class="ml-3 font-medium transition-all duration-200 origin-left"
                        :class="props.isCollapsed ? 'opacity-0 w-0 hidden' : 'opacity-100 w-auto block'"
                    >
                        {{ item.name }}
                    </span>
                </Link>
            </template>
        </nav>

        <div class="p-4 flex-shrink-0 border-t border-[#1f2128]">
            <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="w-full flex items-center justify-center lg:justify-start text-gray-500 hover:text-red-400 transition group whitespace-nowrap"
                :class="props.isCollapsed ? 'px-0' : 'px-2'"
            >
                <svg class="w-6 h-6 group-hover:text-red-400 flex-shrink-0"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span 
                    class="ml-3 text-sm font-medium transition-all duration-200 origin-left"
                    :class="props.isCollapsed ? 'opacity-0 w-0 hidden' : 'opacity-100 w-auto block'"
                >
                    Log Out
                </span>
            </Link>
        </div>
    </aside>
</template>