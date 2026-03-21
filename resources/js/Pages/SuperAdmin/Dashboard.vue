<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

// Kita terima data stats dari controller nanti, sementara kita hardcode dulu
const stats = [
    { name: 'Total Products', value: '120', icon: '📦', color: 'bg-blue-500' },
    { name: 'Low Stock Items', value: '5', icon: '⚠️', color: 'bg-red-500' },
    { name: 'Total Value', value: 'Rp 25.000.000', icon: '💰', color: 'bg-green-500' },
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                OmniTerminal Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 flex justify-between items-center">
                        <div>
                            <p class="text-lg font-medium">Selamat Datang, {{ $page.props.auth.user.name }}!</p>
                            <p class="text-sm text-gray-500">Kelola operasional bisnis Anda di sini.</p>
                        </div>
                        <Link 
                            :href="route('products.index')" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150"
                        >
                            Buka Master Produk
                        </Link>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div v-for="item in stats" :key="item.name" class="bg-white p-6 shadow-sm rounded-lg border-l-4" :class="item.color.replace('bg-', 'border-')">
                        <div class="flex items-center">
                            <div class="text-3xl mr-4">{{ item.icon }}</div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium uppercase">{{ item.name }}</p>
                                <p class="text-2xl font-bold text-gray-900">{{ item.value }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4">Aktivitas Terakhir</h3>
                    <div class="border-t border-gray-100 py-4 text-sm text-gray-500 italic">
                        Belum ada aktivitas transaksi atau perubahan stok baru-baru ini.
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>