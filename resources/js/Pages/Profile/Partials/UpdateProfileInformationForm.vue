<script setup>
import { useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: { type: Boolean },
    status:          { type: String },
});

const user = usePage().props.auth.user;

const form = useForm({
    name:  user.name,
    email: user.email,
});
</script>

<template>
    <section>
        <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-1">Informasi Profil</h3>
        <p class="text-xs text-gray-500 mb-6">Perbarui nama dan alamat email akun kamu.</p>

        <form @submit.prevent="form.patch(route('profile.update'))" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                <input
                    v-model="form.name"
                    type="text"
                    class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2.5 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]"
                    required autofocus
                >
                <div v-if="form.errors.name" class="text-red-400 text-xs mt-1">{{ form.errors.name }}</div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Email</label>
                <input
                    v-model="form.email"
                    type="email"
                    class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2.5 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]"
                    required
                >
                <div v-if="form.errors.email" class="text-red-400 text-xs mt-1">{{ form.errors.email }}</div>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="bg-gradient-to-r from-[#8c52ff] to-[#5e17eb] hover:from-[#7b42ea] hover:to-[#4a0dd6] text-white font-bold px-6 py-2.5 rounded-md text-sm transition-all disabled:opacity-50"
                >
                    {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                </button>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0" leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-green-400">Tersimpan.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>