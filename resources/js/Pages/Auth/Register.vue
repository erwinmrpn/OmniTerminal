<script setup>
import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Toggle show/hide password
const showPassword = ref(false);
const showConfirm  = ref(false);

const form = useForm({
    name:                  '',
    email:                 '',
    password:              '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register - OmniTerminal" />

        <div class="mb-6 text-center">
            <h2 class="text-xl font-bold text-white">Buat Akun Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Daftarkan toko kamu ke OmniTerminal</p>
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <!-- Nama -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                <input
                    v-model="form.name"
                    type="text"
                    class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2.5 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]"
                    placeholder="Nama kamu"
                    required autofocus
                >
                <div v-if="form.errors.name" class="text-red-400 text-xs mt-1">{{ form.errors.name }}</div>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Email</label>
                <input
                    v-model="form.email"
                    type="email"
                    class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2.5 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]"
                    placeholder="email@gmail.com"
                    required
                >
                <div v-if="form.errors.email" class="text-red-400 text-xs mt-1">{{ form.errors.email }}</div>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Password</label>
                <div class="relative">
                    <input
                        v-model="form.password"
                        :type="showPassword ? 'text' : 'password'"
                        class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2.5 pr-10 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]"
                        placeholder="Min. 8 karakter"
                        required
                    >
                    <!-- Tombol show/hide password -->
                    <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition-colors">
                        <svg v-if="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg v-else class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/></svg>
                    </button>
                </div>
                <div v-if="form.errors.password" class="text-red-400 text-xs mt-1">{{ form.errors.password }}</div>
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Konfirmasi Password</label>
                <div class="relative">
                    <input
                        v-model="form.password_confirmation"
                        :type="showConfirm ? 'text' : 'password'"
                        class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2.5 pr-10 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]"
                        placeholder="Ulangi password"
                        required
                    >
                    <!-- Tombol show/hide konfirmasi password -->
                    <button type="button" @click="showConfirm = !showConfirm" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition-colors">
                        <svg v-if="!showConfirm" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg v-else class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 4.411m0 0L21 21"/></svg>
                    </button>
                </div>
                <div v-if="form.errors.password_confirmation" class="text-red-400 text-xs mt-1">{{ form.errors.password_confirmation }}</div>
            </div>

            <!-- Submit -->
            <button
                type="submit"
                :disabled="form.processing"
                class="w-full bg-gradient-to-r from-[#8c52ff] to-[#5e17eb] hover:from-[#7b42ea] hover:to-[#4a0dd6] text-white font-bold py-2.5 rounded-md text-sm transition-all disabled:opacity-50 mt-2"
            >
                {{ form.processing ? 'Memproses...' : 'Daftar Sekarang' }}
            </button>

            <p class="text-center text-sm text-gray-600 pt-2">
                Sudah punya akun?
                <Link :href="route('login')" class="text-[#8c52ff] hover:text-[#a97dff] transition-colors">Masuk di sini</Link>
            </p>
        </form>
    </GuestLayout>
</template>