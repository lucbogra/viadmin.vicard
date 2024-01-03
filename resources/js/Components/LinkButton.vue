<script setup>
import { computed, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import Loader from './Loader.vue';

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
    outline: {
        type: Boolean,
        default: false,
    },
});

const themes = {
    'primary': {
        'solid': 'border border-transparent bg-gray-700 hover:bg-opacity-80 focus:bg-gray-500 active:bg-gray-900 text-white',
        'outline': 'bg-white border hover:bg-gray-700 hover:text-white border-gray-700  text-gray-900 bg-gray-50 focus:bg-gray-100 active:bg-gray-100',
    },
    'secondary': {
        'solid': 'bg-white border hover:bg-gray-100 border-gray-900  text-gray-700 bg-gray-50 focus:bg-gray-100 active:bg-gray-100',
        'outline': ''
    },
    'warning': {
        'solid': 'border border-transparent bg-orange-600 hover:bg-orange-500 focus:bg-orange-500 active:bg-orange-700 text-white',
        'outline': ''
    },
    'danger': {
        'solid': 'border border-transparent bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-700 text-white',
        'outline': 'border border-red-600 text-red-600 bg-white hover:bg-red-600 focus:bg-red-700 active:bg-red-800 hover:text-white'
    },
    'success': {
        'solid': 'border border-transparent bg-green-800 hover:bg-green-700 focus:bg-green-700 active:bg-green-900 text-white',
        'outline': ''
    },
}

const themeClass = computed(() => {
    let x = 'solid';

    if (props.outline == true) {
        x = 'outline';
    }

    return themes[props.theme][x];
});

const sharedClass = ref('inline-flex items-center rounded-md font-semibold text-xs uppercase tracking-widest transition-all shadow hover:shadow-lg duration-300 disabled:opacity-25');

const padding = computed(() => {
    return 'px-4 py-1';
});

</script>

<template>
    <Link v-if="type == 'link'" :disabled="processing" :class="[sharedClass, themeClass, { 'opacity-25 cursor-not-allowed': processing } ]" :href="href">
        <slot />
        <span v-if="processing" class="ml-1">...</span>
    </Link>

    <a v-else-if="type == 'a'" :disabled="processing" :class="[sharedClass, themeClass, { 'opacity-25 cursor-not-allowed': processing } ]" :href="href">
        <slot />
        <span v-if="processing" class="ml-1">...</span>
    </a>

    <button v-else :type="type" :disabled="processing" :class="[sharedClass, themeClass, { 'opacity-25': processing } ]">

        <Loader v-if="processing" />
        <slot />

    </button>

</template>
