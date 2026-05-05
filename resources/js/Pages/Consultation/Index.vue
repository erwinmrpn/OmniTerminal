<script setup>
import { ref } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    name:     '',
    business: '',
    whatsapp: '',
    email:    '',
    message:  '',
});

const showSuccess = ref(false);

const submit = () => {
    form.post(route('consultation.store'), {
        onSuccess: () => {
            showSuccess.value = true;
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Consultation - OmniTerminal" />

    <div class="min-h-screen bg-[#0a0b0d] text-gray-300 font-sans flex flex-col">

        <!-- Navbar -->
        <nav class="flex items-center justify-between px-8 py-5 border-b border-[#1f2128]">
            <Link href="/" class="flex items-center gap-3">
                <img src="/image/logo_nobg.png" alt="OmniTerminal" class="w-8 h-8 object-contain" />
                <span class="font-bold text-white text-lg tracking-wide">OmniTerminal</span>
            </Link>
            <div class="flex items-center gap-3">
                <Link href="/" class="inline-flex items-center gap-1.5 text-xs text-gray-500 hover:text-gray-300 transition-colors px-2 py-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </Link>
                <Link href="/login" class="text-sm font-bold text-gray-400 hover:text-white transition-colors px-4 py-2">
                    Log In
                </Link>
            </div>
        </nav>

        <!-- Form -->
        <main class="flex-1 flex items-center justify-center px-6 py-16">
            <div class="w-full max-w-lg">

                <!-- Header -->
                <div class="mb-8 text-center">
                    <h1 class="text-2xl font-black text-white mb-2">Start a Consultation</h1>
                    <p class="text-gray-500 text-sm">Fill in the form below and we'll get back to you as soon as possible.</p>
                </div>

                <!-- Form Card -->
                <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-8">
                    <form @submit.prevent="submit" class="space-y-5">

                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Full Name</label>
                            <input
                                v-model="form.name"
                                type="text"
                                class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2.5 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]"
                                placeholder="Your full name"
                                required
                            >
                            <div v-if="form.errors.name" class="text-red-400 text-xs mt-1">{{ form.errors.name }}</div>
                        </div>

                        <!-- Bisnis -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">What do you sell on e-commerce?</label>
                            <input
                                v-model="form.business"
                                type="text"
                                class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2.5 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]"
                                placeholder="e.g. Skincare, Fashion, Electronics"
                                required
                            >
                            <div v-if="form.errors.business" class="text-red-400 text-xs mt-1">{{ form.errors.business }}</div>
                        </div>

                        <!-- WhatsApp -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">WhatsApp Number</label>
                            <input
                                v-model="form.whatsapp"
                                type="text"
                                class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2.5 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]"
                                placeholder="e.g. 08123456789"
                                required
                            >
                            <div v-if="form.errors.whatsapp" class="text-red-400 text-xs mt-1">{{ form.errors.whatsapp }}</div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Email Address</label>
                            <input
                                v-model="form.email"
                                type="email"
                                class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2.5 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff]"
                                placeholder="your@email.com"
                                required
                            >
                            <div v-if="form.errors.email" class="text-red-400 text-xs mt-1">{{ form.errors.email }}</div>
                        </div>

                        <!-- Pesan -->
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                                Message <span class="normal-case text-gray-600">(max 500 characters)</span>
                            </label>
                            <textarea
                                v-model="form.message"
                                rows="4"
                                maxlength="500"
                                class="w-full bg-[#0a0b0d] border border-[#2d2f36] rounded-md px-3 py-2.5 text-sm text-gray-300 focus:outline-none focus:border-[#8c52ff] focus:ring-1 focus:ring-[#8c52ff] resize-none"
                                placeholder="Tell us about your business and what you need..."
                                required
                            ></textarea>
                            <div class="flex justify-between mt-1">
                                <div v-if="form.errors.message" class="text-red-400 text-xs">{{ form.errors.message }}</div>
                                <p class="text-gray-600 text-xs ml-auto">{{ form.message.length }}/500</p>
                            </div>
                        </div>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full bg-gradient-to-r from-[#8c52ff] to-[#5e17eb] hover:from-[#7b42ea] hover:to-[#4a0dd6] text-white font-bold py-3 rounded-xl text-sm transition-all disabled:opacity-50"
                        >
                            {{ form.processing ? 'Sending...' : 'Send Message' }}
                        </button>

                    </form>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-[#1f2128] py-5 text-center">
            <p class="text-xs text-gray-600">&copy; 2026 OmniTerminal. All rights reserved.</p>
        </footer>
    </div>

    <!-- Popup Success -->
    <div v-if="showSuccess" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm">
        <div class="bg-[#121317] border border-[#2d2f36] rounded-xl p-8 w-full max-w-sm shadow-2xl text-center">
            <div class="w-14 h-14 rounded-full bg-green-500/10 flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-white font-bold text-lg mb-2">Message Sent!</h3>
            <p class="text-gray-400 text-sm leading-relaxed mb-6">Your message has been sent! Admin will contact you for further consultation.</p>
            <button
                @click="showSuccess = false"
                class="w-full bg-gradient-to-r from-[#8c52ff] to-[#5e17eb] text-white font-bold py-2.5 rounded-lg text-sm transition-all hover:from-[#7b42ea] hover:to-[#4a0dd6]"
            >
                OK
            </button>
        </div>
    </div>
</template>