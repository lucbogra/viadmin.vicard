<script setup>
import { computed, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
// import { themes } from '../Composables/Theme.js';

const props = defineProps({
    classes: {
        type: String,
        default: '',
    },
});

</script>

<template>
    <div
        class="inline-block mr-1 h-4 w-4 animate-spin rounded-full border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
        role="status">
        <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span
    >
    </div>
</template>
