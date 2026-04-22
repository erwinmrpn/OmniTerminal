<script setup>
import { ref, nextTick } from 'vue';
import { useForm } from '@inertiajs/vue3';

const confirmingDeletion = ref(false);
const passwordInput      = ref(null);

const form = useForm({ password: '' });

const confirmDeletion = () => {
    confirmingDeletion.value = true;
    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError:   () => passwordInput.value.focus(),
        onFinish:  () => form.reset(),
    });
};

const closeModal = () => {
    confirmingDeletion.value = false;
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section>
        <h3 class="text-sm font-bold text-red-400 uppercase tracking-wider mb-1">Hapus Akun</h3>
        <p class="text-xs text-gray-500 mb-6">Setelah akun dihapus, semua data akan hilang permanen. Pastikan kamu sudah backup data penting sebelum melanjutkan.</p>

        <button
            @click="confirmDeletion"
            class="bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 font-bold px-6 py-2.5 rounded-md text-sm transition-all"
        >
            Hapus Akun Saya
        </button>

        <!-- Modal Konfirmasi Hapus Akun -->
        <div v-if="confirmingDeletion" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">
            <div class="bg-[#121317] border border-red-900/40 rounded-xl p-6 w-full max-w-md shadow-xl">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-2">Yakin ingin hapus akun?</h3>
                <p class="text-xs text-gray-500 mb-6">Tindakan ini tidak bisa dibatalkan. Masukkan password kamu untuk konfirmasi.</p>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Password</label>
                    <input
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2.5 text-sm text-gray-300 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500"
                        placeholder="••••••••"
                        @keyup.enter="deleteUser"
                    >
                    <div v-if="form.errors.password" class="text-red-400 text-xs mt-1">{{ form.errors.password }}</div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" @click="closeModal" class="flex-1 bg-[#1f2128] hover:bg-[#2d2f36] text-gray-300 font-bold py-2.5 rounded-md text-sm transition-all">
                        Batal
                    </button>
                    <button
                        type="button"
                        @click="deleteUser"
                        :disabled="form.processing"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-md text-sm transition-all disabled:opacity-50"
                    >
                        {{ form.processing ? 'Menghapus...' : 'Ya, Hapus Akun' }}
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>