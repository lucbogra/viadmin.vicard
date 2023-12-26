<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    type: {
        type: String,
        default: 'link',
    },
    theme: {
        type: String,
        default: "primary"
    },      
    href: {
        type: String,
        default: "#"
    },      
    processing: {
        type: Boolean,
        default: false,
    },
});

const themeClass = computed(() => {
    return {
        'primary': 'border border-transparent bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 text-white',
        'secondary': 'bg-white border hover:bg-gray-100 border-gray-300 text-gray-700 bg-gray-50 focus:bg-gray-100 active:bg-gray-100',
        'warning': 'border border-transparent bg-orange-600 hover:bg-orange-500 focus:bg-orange-500 active:bg-orange-700 text-white',
        'danger': 'border border-transparent bg-red-800 hover:bg-red-700 focus:bg-red-700 active:bg-red-900 text-white',
        'success': 'border border-transparent bg-green-800 hover:bg-green-700 focus:bg-green-700 active:bg-green-900 text-white',
    }[props.theme];
});

const sharedClass = computed(() => {
    return 'inline-flex items-center rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 disabled:opacity-25';
});

const padding = computed(() => {
    return 'px-4 py-1';
});

</script>

<template>
    <Link v-if="type == 'link'" :disabled="processing" :class="[themeClass, sharedClass]" :href="href">
        <slot />
        <span v-if="processing" class="ml-2">...</span>
    </Link>

    <button v-else :type="type" :disabled="processing" :class="[themeClass, sharedClass]">
        <slot />
        
        <div v-if="processing"
            class="inline-block ml-2 h-4 w-4 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
            role="status">
            <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span
        >
        </div>
        <!-- <span v-if="processing" class="ml-2">...</span> -->
    </button>
</template>
