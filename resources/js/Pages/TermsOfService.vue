<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Footer from '@/Components/Footer.vue';
</script>

<template>
    <Head title="Terms of Service - OmniTerminal" />

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
                <h1 class="text-3xl font-black text-white mb-2">Terms of Service</h1>
                <p class="text-gray-500 text-sm">Last updated: May 2026</p>
            </div>

            <div class="space-y-8 text-sm leading-relaxed">

                <!-- 1 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#8c52ff]/20 text-[#8c52ff] text-xs font-black flex items-center justify-center flex-shrink-0">1</span>
                        Agreement to Terms
                    </h2>
                    <p class="text-gray-400">
                        By accessing or using OmniTerminal, you agree to be bound by these Terms of Service. OmniTerminal is a warehouse management system (WMS) designed to help e-commerce businesses manage their orders, inventory, and warehouse operations. If you do not agree to these terms, please do not use our platform.
                    </p>
                </div>

                <!-- 2 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#8c52ff]/20 text-[#8c52ff] text-xs font-black flex items-center justify-center flex-shrink-0">2</span>
                        Who Can Use OmniTerminal
                    </h2>
                    <p class="text-gray-400 mb-3">
                        OmniTerminal is intended for businesses and individuals who operate e-commerce stores and need a centralized system to manage their warehouse and order fulfillment. To use our platform, you must:
                    </p>
                    <ul class="list-disc list-inside text-gray-400 space-y-1.5 pl-2">
                        <li>Be at least 18 years of age</li>
                        <li>Have a legitimate business or e-commerce operation</li>
                        <li>Provide accurate and complete registration information</li>
                        <li>Keep your account credentials confidential and secure</li>
                    </ul>
                </div>

                <!-- 3 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#8c52ff]/20 text-[#8c52ff] text-xs font-black flex items-center justify-center flex-shrink-0">3</span>
                        Our Services
                    </h2>
                    <p class="text-gray-400 mb-3">OmniTerminal provides the following core features:</p>
                    <ul class="list-disc list-inside text-gray-400 space-y-1.5 pl-2">
                        <li>Real-time warehouse stock management and tracking</li>
                        <li>Order processing and fulfillment management</li>
                        <li>Integration with e-commerce platforms such as Lazada, TikTok Shop, and Shopee</li>
                        <li>Role-based team management for warehouse staff</li>
                        <li>Order history and reporting</li>
                    </ul>
                    <p class="text-gray-400 mt-3">
                        We reserve the right to modify, suspend, or discontinue any part of our services at any time with reasonable notice.
                    </p>
                </div>

                <!-- 4 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#8c52ff]/20 text-[#8c52ff] text-xs font-black flex items-center justify-center flex-shrink-0">4</span>
                        Your Responsibilities
                    </h2>
                    <p class="text-gray-400 mb-3">As a user of OmniTerminal, you agree to:</p>
                    <ul class="list-disc list-inside text-gray-400 space-y-1.5 pl-2">
                        <li>Use the platform only for lawful purposes</li>
                        <li>Not attempt to gain unauthorized access to any part of the system</li>
                        <li>Not use the platform to store or transmit malicious code</li>
                        <li>Keep your account information up-to-date and accurate</li>
                        <li>Notify us immediately of any unauthorized use of your account</li>
                        <li>Not share your account credentials with unauthorized parties</li>
                    </ul>
                </div>

                <!-- 5 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#8c52ff]/20 text-[#8c52ff] text-xs font-black flex items-center justify-center flex-shrink-0">5</span>
                        Third-Party Integrations
                    </h2>
                    <p class="text-gray-400">
                        OmniTerminal integrates with third-party platforms including Lazada Open Platform and TikTok Shop Open API. By connecting your seller accounts to OmniTerminal, you authorize us to access your store data (orders, products, inventory) on your behalf. We are not responsible for the availability, accuracy, or policies of these third-party services. Your use of third-party integrations is also subject to their respective terms of service.
                    </p>
                </div>

                <!-- 6 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#8c52ff]/20 text-[#8c52ff] text-xs font-black flex items-center justify-center flex-shrink-0">6</span>
                        Intellectual Property
                    </h2>
                    <p class="text-gray-400">
                        All content, features, and functionality within OmniTerminal — including but not limited to the software, design, logos, and text — are owned by OmniTerminal and are protected by applicable intellectual property laws. You may not copy, reproduce, or distribute any part of our platform without prior written permission.
                    </p>
                </div>

                <!-- 7 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#8c52ff]/20 text-[#8c52ff] text-xs font-black flex items-center justify-center flex-shrink-0">7</span>
                        Limitation of Liability
                    </h2>
                    <p class="text-gray-400">
                        OmniTerminal is provided on an "as is" basis. We do our best to keep the platform running smoothly, but we cannot guarantee uninterrupted or error-free service. To the fullest extent permitted by law, OmniTerminal shall not be liable for any indirect, incidental, or consequential damages arising from your use of the platform.
                    </p>
                </div>

                <!-- 8 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#8c52ff]/20 text-[#8c52ff] text-xs font-black flex items-center justify-center flex-shrink-0">8</span>
                        Termination
                    </h2>
                    <p class="text-gray-400">
                        We reserve the right to suspend or terminate your access to OmniTerminal if you violate these Terms of Service or engage in any conduct that we determine, at our sole discretion, to be harmful to the platform or other users. Upon termination, your right to use the platform will immediately cease.
                    </p>
                </div>

                <!-- 9 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#8c52ff]/20 text-[#8c52ff] text-xs font-black flex items-center justify-center flex-shrink-0">9</span>
                        Changes to These Terms
                    </h2>
                    <p class="text-gray-400">
                        We may update these Terms of Service from time to time. When we make significant changes, we will notify users through the platform. Your continued use of OmniTerminal after any changes constitutes your acceptance of the new terms.
                    </p>
                </div>

                <!-- 10 -->
                <div>
                    <h2 class="text-white font-bold text-base mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-[#8c52ff]/20 text-[#8c52ff] text-xs font-black flex items-center justify-center flex-shrink-0">10</span>
                        Contact Us
                    </h2>
                    <p class="text-gray-400">
                        If you have any questions about these Terms of Service, please feel free to reach out to us through the consultation form on our website or contact us at
                        <a href="mailto:hello@omniterminal.id" class="text-[#8c52ff] hover:text-[#a97dff] transition-colors">hello@omniterminal.id</a>.
                    </p>
                </div>

            </div>
        </main>

        <Footer />
    </div>
</template>