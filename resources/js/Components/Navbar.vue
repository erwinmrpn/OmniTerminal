<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    isSidebarOpen: Boolean,
});

defineEmits(['toggle-sidebar']);

const page = usePage();
const user = computed(() => page.props.auth.user);

// Logika Inisial Avatar
const userInitial = computed(() => {
    return user.value && user.value.name 
        ? user.value.name.charAt(0).toUpperCase() 
        : '?';
});

const avatarGradient = 'bg-gradient-to-br from-[#8c52ff] to-[#5e17eb]';
</script>

<template>
    <nav class="sticky top-0 z-30 h-16 flex items-center justify-between px-6 lg:px-8 bg-[#0a0b0d] border-b border-[#1f2128] transition-colors duration-300">
        
        <div class="flex-1 flex items-center gap-4"></div>

        <div class="w-full max-w-xl px-4 hidden md:block">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" class="block w-full pl-10 pr-3 py-2 border border-[#2d2f36] rounded-md leading-5 bg-[#1a1b20] text-gray-300 placeholder-gray-500 focus:outline-none focus:bg-[#25262c] focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm transition-colors" placeholder="Search across OmniTerminal...">
            </div>
        </div>

        <div class="flex-1 flex justify-end items-center gap-4 ml-4">
            
            <button class="text-gray-400 hover:text-white transition relative p-2 rounded-lg hover:bg-[#1a1b20]">
                <div class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border border-[#0a0b0d]"></div>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
            </button>
            
            <div class="relative group h-full flex items-center">
                
                <div 
                    class="h-9 w-9 rounded-full border border-gray-600 cursor-pointer group-hover:border-white transition shadow-lg flex items-center justify-center text-xs font-bold text-white select-none"
                    :class="avatarGradient"
                >
                    {{ userInitial }}
                </div>

                <div class="absolute top-full right-0 mt-2 w-64 bg-[#1a1b20] border border-[#2d2f36] rounded-xl shadow-2xl 
                            invisible opacity-0 transform translate-y-2 
                            group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 
                            transition-all duration-200 ease-out origin-top-right z-50">
                    
                    <div class="px-4 py-4 border-b border-[#2d2f36] flex items-center gap-3">
                        <div 
                            class="h-10 w-10 rounded-full flex-shrink-0 flex items-center justify-center text-sm font-bold text-white select-none"
                            :class="avatarGradient"
                        >
                            {{ userInitial }}
                        </div>

                        <div class="overflow-hidden">
                            <h4 class="text-sm font-bold text-white truncate">
                                {{ user ? user.name : 'User' }}
                            </h4>
                            <p class="text-xs text-gray-500 truncate">
                                <span class="uppercase font-bold text-blue-400 text-[10px] mr-1">[{{ user.role }}]</span>
                                {{ user ? user.email : 'email@example.com' }}
                            </p>
                        </div>
                    </div>

                    <div class="py-2">
                        <Link :href="route('profile.edit')" class="flex items-center px-4 py-2.5 text-sm text-gray-300 hover:bg-[#25262c] hover:text-white transition-colors">
                            <svg class="w-4 h-4 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Account & Settings
                        </Link>

                        <div class="border-t border-[#2d2f36] my-1"></div>

                        <Link :href="route('logout')" method="post" as="button" class="w-full text-left flex items-center px-4 py-2.5 text-sm text-gray-300 hover:bg-[#25262c] hover:text-red-400 transition-colors">
                            <svg class="w-4 h-4 mr-3 text-gray-500 group-hover:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            Log Out
                        </Link>

                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>