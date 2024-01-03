<script setup>
import { computed } from "vue";

defineProps({
    label: String,
    position: {
        type: String,
        default: "start"
    },
    bold: Boolean
});

</script>

<template>
    <td class="py-2 px-4 text-gray-600 tracking-normal text-sm" :class="{'font-bold': bold, 'font-light': !bold}">
        <span v-if="label">{{ label }}</span>
        <slot v-else />
    </td>
</template>
