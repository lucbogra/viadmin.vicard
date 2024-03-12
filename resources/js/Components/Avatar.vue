<script setup>
import { computed } from "vue";
import { Icon } from '@iconify/vue';

const props = defineProps({
    image: String,
    icon: {
        type: String,
        default: "material-symbols-light:photo-camera-outline"
    },
    border: {
        type: Boolean,
        default: true
    },
    rounded: {
        type: String,
        default: 'full'
    },
    size: {
        type: String,
        default: '8'
    },
});

const classes = computed(() => {
    let cls = ''

    if (props.rounded = 'full') {
        cls += ' rounded-full';
    } else {
        cls += ' rounded';
    }

    switch (props.size) {
        case "2":
            cls += ' w-2 h-2';
            break;
        case "3":
            cls += ' w-3 h-3';
            break;
        case "4":
            cls += ' w-4 h-4';
            break;
        case "6":
            cls += ' w-6 h-6';
            break;
        case "8":
            cls += ' w-8 h-8';
            break;
        case "10":
            cls += ' w-10 h-10';
            break;
        case "12":
            cls += ' w-12 h-12';
            break;
        case "14":
            cls += ' w-14 h-14';
            break;
        case "16":
            cls += ' w-16 h-16';
            break;
        case "18":
            cls += ' w-18 h-18';
            break;
        case "20":
            cls += ' w-20 h-20';
            break;
        case "24":
            cls += ' w-24 h-24';
            break;
        case "28":
            cls += ' w-28 h-28';
            break;
        case "32":
            cls += ' w-32 h-32';
            break;
        case "36":
            cls += ' w-36 h-36';
            break;
    
        default:
            cls += ' w-4 h-4';
            break;
    }

    return cls;
});

</script>

<template>
    <div :class="[{'border border-gray-400': border}, 'group flex items-center justify-center overflow-hidden', classes]">
        <img v-if="image" class="object-cover w-full h-full scale-100 group-hover:scale-110 transition duration-200 ease-in-out" :src="image" alt="">
        <Icon v-else :icon="icon" class="text-gray-400 w-[70%] h-[70%] scale-90 group-hover:scale-100 transition duration-200 ease-in-out" />
    </div>
</template>
