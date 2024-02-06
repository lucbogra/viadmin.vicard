<script setup>
import { computed, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import Loader from './Loader.vue';
import { Icon } from '@iconify/vue';

const props = defineProps({
    type: {
        type: String,
        default: 'link',
    },
    title: {
        type: String,
        default: null,
    },
    theme: {
        type: String,
        default: "primary"
    },
    href: {
        type: String,
        default: "#"
    },
    blank: {
        type: Boolean,
        default: false
    },
    processing: {
        type: Boolean,
        default: false,
    },
    label: String,
    icon: String,
    action: String,
    buttonIcon: String
});

const lightThemes = {
    'primary': 'border bg-teal-100 hover:bg-teal-200 border-teal-300 focus:bg-teal-100 active:bg-teal-100 text-teal-700',
    'secondary': 'bg-blue-200 border hover:bg-blue-100 border-blue-300 text-blue-700 bg-blue-50 focus:bg-blue-100 active:bg-blue-100',
    'warning': 'border bg-orange-100 hover:bg-orange-200 border-orange-300 focus:bg-orange-100 active:bg-orange-100 text-orange-700',
    'danger': 'border bg-red-100 hover:bg-red-200 border-red-300 focus:bg-red-100 active:bg-red-100 text-red-700',
    'success': 'border bg-green-100 hover:bg-green-200 border-green-300 focus:bg-green-100 active:bg-green-100 text-green-700',
    'pink': 'border bg-pink-100 hover:bg-pink-200 border-pink-300 focus:bg-pink-100 active:bg-pink-100 text-pink-700',
    'indigo': 'border bg-indigo-100 hover:bg-indigo-200 border-indigo-300 focus:bg-indigo-100 active:bg-indigo-100 text-indigo-700',
    'purple': 'border bg-purple-100 hover:bg-purple-200 border-purple-300 focus:bg-purple-100 active:bg-purple-100 text-purple-700',
    'fuchsia': 'border bg-fuchsia-100 hover:bg-fuchsia-200 border-fuchsia-300 focus:bg-fuchsia-100 active:bg-fuchsia-100 text-fuchsia-700',
}

const themeClass = computed(() => {
    return lightThemes[props.theme];
});

const icon = computed(() => {

    if (props.buttonIcon) {
        return props.buttonIcon
    }

    switch (props.action) {
        case 'show':
            return 'ri:eye-line'
            break;
        case 'edit':
            return 'mynaui:edit'
            break;
        case 'duplicate':
            return 'uil:copy'
            break;
        case 'delete':
            return 'gg:trash'
            break;
    
        default:
            return 
            break;
    }
});

const color = computed(() => {
    switch (props.action) {
        case 'show':
            return lightThemes['primary']
            break;
        case 'edit':
            return lightThemes['secondary']
            break;
            case 'delete':
            return lightThemes['danger']
            break;
        case 'duplicate':
            return lightThemes['indigo']
            break;
    
        default:
            return null
            break;
    }
});

const staticTitle = computed(() => {
    switch (props.action) {
        case 'show':
            return "Details"
            break;
        case 'edit':
            return "Editer"
            break;
        case 'delete':
            return "Supprimer"
            break;
        case 'duplicate':
            return "Dupliquer"
            break;
    
        default:
            return null
            break;
    }
});

const sharedClass = ref('inline-flex items-center h-8 items-center transition-all duration-500 justify-center border rounded-full font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150 disabled:opacity-25')

</script>

<template>
    <Link :title="staticTitle ?? title" v-if="type == 'link'" :disabled="processing" :class="[sharedClass, color ?? themeClass, { 'opacity-25 cursor-not-allowed': processing, 'px-2': label, 'w-8': !label } ]" :href="href">
        <Loader v-if="processing" />

        <div v-else class="h-full w-full flex justify-center items-center">
            <Icon v-if="icon" :icon="icon" class="w-[60%] h-[60%]" />
            <slot v-else />
        </div>
    </Link>

    <a :title="staticTitle ?? title" v-else-if="type == 'a'"
        :disabled="processing"
        :class="[sharedClass, color ?? themeClass, { 'opacity-25 cursor-not-allowed': processing, 'px-2': label, 'w-8': !label } ]"
        :href="href"
        :target="blank ? '_blank' : ''"
    >
        <Loader v-if="processing" />

         <div v-else class="h-full w-full flex justify-center items-center">
            <Icon v-if="icon" :icon="icon" class="w-[60%] h-[60%]" />
            <slot v-else />
        </div>
    </a>

    <button :title="staticTitle ?? title" v-else :type="type" :disabled="processing" :class="[sharedClass, color ?? themeClass, { 'opacity-25': processing, 'px-2': label, 'w-8': !label } ]">

        <Loader v-if="processing" />

         <div v-else class="h-full w-full flex justify-center items-center">
            <Icon v-if="icon" :icon="icon" class="w-[60%] h-[60%]" />
            <slot v-else />
            <span v-if="label" class="text-xs">{{ label }}</span>
        </div>

    </button>

</template>
