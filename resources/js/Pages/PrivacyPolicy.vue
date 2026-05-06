<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';
</script>

<template>
    <Head title="Privacy Policy - OmniTerminal" />

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

        <!-- Content -->
        <main class="flex-1 px-6 py-16 max-w-3xl mx-auto w-full">

            <div class="mb-10">
                <h1 class="text-3xl font-black text-white mb-2">Privacy Policy</h1>
                <p class="text-gray-500 text-sm">Last updated: May 2026</p>
            </div>

            <div class="space-y-8 text-sm leading-relaxed">

                <!-- Intro -->
                <div class="bg-[#121317] border border-[#1f2128] rounded-xl p-5">
                    <p class="text-gray-400">
                        At OmniTerminal, we take your privacy seriously. This Privacy Policy explains how we collect, use, and protect your personal information when you use our warehouse management platform. We believe in being transparent — no confusing legal jargon, just a clear explanation of what we do with your data.
                    </p>
                </div>

                <!-- 1 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#5ce1e6]/20 text-[#5ce1e6] text-xs font-black flex items-center justify-center flex-shrink-0">1</span>
                        Information We Collect
                    </h2>
                    <p class="text-gray-400 mb-3">We collect the following types of information when you use OmniTerminal:</p>
                    <div class="space-y-3">
                        <div class="bg-[#121317] border border-[#1f2128] rounded-lg px-4 py-3">
                            <p class="text-white text-xs font-bold mb-1">Account Information</p>
                            <p class="text-gray-500 text-xs">Your name, email address, and password when you register for an account.</p>
                        </div>
                        <div class="bg-[#121317] border border-[#1f2128] rounded-lg px-4 py-3">
                            <p class="text-white text-xs font-bold mb-1">Business Information</p>
                            <p class="text-gray-500 text-xs">Your business or store name, and details provided during consultation or onboarding.</p>
                        </div>
                        <div class="bg-[#121317] border border-[#1f2128] rounded-lg px-4 py-3">
                            <p class="text-white text-xs font-bold mb-1">E-commerce Data</p>
                            <p class="text-gray-500 text-xs">Order data, product information, and inventory levels synced from connected platforms (Lazada, TikTok Shop, Shopee).</p>
                        </div>
                        <div class="bg-[#121317] border border-[#1f2128] rounded-lg px-4 py-3">
                            <p class="text-white text-xs font-bold mb-1">Usage Data</p>
                            <p class="text-gray-500 text-xs">How you interact with the platform, including pages visited and features used — to help us improve the experience.</p>
                        </div>
                    </div>
                </div>

                <!-- 2 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#5ce1e6]/20 text-[#5ce1e6] text-xs font-black flex items-center justify-center flex-shrink-0">2</span>
                        How We Use Your Information
                    </h2>
                    <p class="text-gray-400 mb-3">We use your information to:</p>
                    <ul class="list-disc list-inside text-gray-400 space-y-1.5 pl-2">
                        <li>Provide and maintain the OmniTerminal platform</li>
                        <li>Process and display your orders and inventory data</li>
                        <li>Sync data between your store and connected e-commerce platforms</li>
                        <li>Send important account and service notifications</li>
                        <li>Respond to your consultation requests and support inquiries</li>
                        <li>Improve and develop new features based on usage patterns</li>
                    </ul>
                    <p class="text-gray-400 mt-3">
                        We do <span class="text-white font-medium">not</span> sell your personal data to third parties. Ever.
                    </p>
                </div>

                <!-- 3 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#5ce1e6]/20 text-[#5ce1e6] text-xs font-black flex items-center justify-center flex-shrink-0">3</span>
                        Third-Party Platform Integrations
                    </h2>
                    <p class="text-gray-400">
                        When you connect your seller accounts (Lazada, TikTok Shop, Shopee) to OmniTerminal, we access your store data using the official APIs provided by those platforms. This includes order details, product listings, and stock levels. This data is used solely to power the features within OmniTerminal and is never shared with other parties. Your platform credentials (access tokens) are stored securely and encrypted.
                    </p>
                </div>

                <!-- 4 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#5ce1e6]/20 text-[#5ce1e6] text-xs font-black flex items-center justify-center flex-shrink-0">4</span>
                        Data Storage & Security
                    </h2>
                    <p class="text-gray-400">
                        Your data is stored on secure servers hosted in Indonesia. We implement industry-standard security measures including encrypted connections (HTTPS), hashed passwords, and role-based access controls to protect your information. While we take every reasonable precaution, no system is 100% immune to security risks — we encourage you to use a strong, unique password for your account.
                    </p>
                </div>

                <!-- 5 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#5ce1e6]/20 text-[#5ce1e6] text-xs font-black flex items-center justify-center flex-shrink-0">5</span>
                        Data Retention
                    </h2>
                    <p class="text-gray-400">
                        We retain your data for as long as your account is active or as needed to provide our services. If you choose to close your account, we will delete your personal data within 30 days, except where we are required by law to retain it longer.
                    </p>
                </div>

                <!-- 6 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#5ce1e6]/20 text-[#5ce1e6] text-xs font-black flex items-center justify-center flex-shrink-0">6</span>
                        Your Rights
                    </h2>
                    <p class="text-gray-400 mb-3">You have the right to:</p>
                    <ul class="list-disc list-inside text-gray-400 space-y-1.5 pl-2">
                        <li><span class="text-gray-300 font-medium">Access</span> — request a copy of the personal data we hold about you</li>
                        <li><span class="text-gray-300 font-medium">Correction</span> — update or correct inaccurate information</li>
                        <li><span class="text-gray-300 font-medium">Deletion</span> — request that we delete your personal data</li>
                        <li><span class="text-gray-300 font-medium">Portability</span> — request your data in a machine-readable format</li>
                        <li><span class="text-gray-300 font-medium">Objection</span> — object to certain types of data processing</li>
                    </ul>
                    <p class="text-gray-400 mt-3">To exercise any of these rights, please contact us using the details below.</p>
                </div>

                <!-- 7 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#5ce1e6]/20 text-[#5ce1e6] text-xs font-black flex items-center justify-center flex-shrink-0">7</span>
                        Cookies
                    </h2>
                    <p class="text-gray-400">
                        OmniTerminal uses essential cookies to keep you logged in and remember your preferences (such as sidebar state). We do not use tracking or advertising cookies. You can control cookie settings through your browser, though disabling essential cookies may affect platform functionality.
                    </p>
                </div>

                <!-- 8 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#5ce1e6]/20 text-[#5ce1e6] text-xs font-black flex items-center justify-center flex-shrink-0">8</span>
                        Changes to This Policy
                    </h2>
                    <p class="text-gray-400">
                        We may update this Privacy Policy as our platform evolves. When we make meaningful changes, we'll notify you through the platform. The "Last updated" date at the top of this page always reflects the most recent version.
                    </p>
                </div>

                <!-- 9 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#5ce1e6]/20 text-[#5ce1e6] text-xs font-black flex items-center justify-center flex-shrink-0">9</span>
                        Contact Us
                    </h2>
                    <p class="text-gray-400">
                        Have questions or concerns about your privacy? We'd love to hear from you. Reach out through our consultation form or email us directly at
                        <a href="mailto:hello@omniterminal.id" class="text-[#5ce1e6] hover:text-[#8ef5f8] transition-colors">hello@omniterminal.id</a>.
                        We aim to respond within 2 business days.
                    </p>
                </div>

            </div>
        </main>

        <Footer />
    </div>
</template>