<template>
    
    <template v-if="menu.subMenu.length">
        <div :class="[
                menu.current 
                ? 'bg-gray-800 text-white' 
                : 'text-gray-100 hover:bg-gray-600 hover:text-white', 
                'group flex items-center cursor-pointer justify-between rounded-md px-3 py-3 text-sm font-medium leading-6'
            ]" 
                :aria-current="menu.current ? 'page' : undefined"
            @click="menu.current = !menu.current"
        >
            <div class="flex items-center">
                <Icon :icon="menu.icon" class="mr-4 h-5 w-5 flex-shrink-0 text-gray-200" />
                <span class="rtl:ms-2">{{ menu.name }}</span>
            </div>

            <span class="h-6 w-6 rounded-full 
                    flex justify-center items-center
                    ml-auto shrink-0 cursor-pointer fill-[#336dec] 
                    transition-transform duration-200 ease-in-out 
                    group-[[data-te-collapse-collapsed]]:rotate-0 
                    group-[[data-te-collapse-collapsed]]:fill-[#212529] 
                    motion-reduce:transition-none dark:fill-blue-300 
                    dark:group-[[data-te-collapse-collapsed]]:fill-white"
                    :class="menu.current ? 'rotate-[-180deg]' : 'rotate-[-0deg]'"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="h-4 w-4">
                    <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </span>

        </div>

        <template class="transition-height duration-900" :class="menu.current ? 'block h-auto' : 'h-0'">
            <Link :href="subMenu.url" v-for="(subMenu, subMenuIndex) in menu.subMenu" :key="subMenuIndex">
                <div class="flex items-center py-2 hover:bg-gray-600 px-4 cursor-pointer rounded-md transition-all duration-500" :class="subMenuIndex == (menu.subMenu.length - 1) ? 'mb-5' : ''">
                    <div class="w-2 h-2 bg-gray-200 rounded-full mr-2"></div>
                    <p class="text-xs rtl:ms-2 text-white">{{ subMenu.name }}</p>
                </div>
            </Link>
        </template>
    </template>

    <Link v-else :class="[
            menu.current 
            ? 'bg-gray-900 text-white hover:bg-gray-700' 
            : 'text-gray-100 hover:bg-gray-900 hover:text-white', 
            'group flex items-center rounded-md px-3 py-3 text-sm font-medium leading-6'
        ]" 
        :aria-current="
            menu.current 
            ? 'page' 
            : undefined" 
        :href="menu.url"
    >
        <Icon :icon="menu.icon" class="mr-4 h-5 w-5 flex-shrink-0 text-gray-200" />
        <span class="rtl:ms-2">{{ menu.name }}</span>
    
    </Link>

</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Icon } from '@iconify/vue';

defineProps({
    menu: Object,
    device: { type: String, Default: 'web' }
});
</script>