<script setup>
import { computed } from "vue";

const props = defineProps({
    label: String,
    position: {
        type: String,
        default: "start"
    },
    bold: Boolean
});

const positionClass = computed(() => {
    return {
        "start": "justify-start",
        "center": "justify-center",
        "end": "justify-end",
    }[props.position];
});

</script>

<template>
    <td class="py-2 px-4 text-gray-600 tracking-normal text-sm" :class="[{'font-bold': bold, 'font-light': !bold}, positionClass]">
        <span v-if="label">{{ label }}</span>
        <slot v-else />
    </td>
</template>
