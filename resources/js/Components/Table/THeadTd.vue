<script setup>
import { computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';

const props = defineProps({
    label: String,
    sortBy: String,
    currentSortKey: String,
    orderBy: {
        type: String,
        default: 'desc'
    },
    activeSorted: Array,
    position: {
        type: String,
        default: "start"
    }
});

const positionClass = computed(() => {
    return {
        "start": "justify-start",
        "center": "justify-center",
        "end": "justify-end",
    }[props.position];
});

const emit = defineEmits(['onSort']);
</script>

<template>
    <th class="py-4 px-4 font-bold text-left tracking-normal text-xs">
        
        <div class="flex space-x-1 items-center" 
            :class="[{'cursor-pointer': sortBy != null, 'text-gray-900 font-extrabold': (sortBy != null && sortBy == currentSortKey)}, positionClass]"
            @click="sortBy == null ? null : $emit('onSort', sortBy, (orderBy = orderBy == 'asc' ? 'desc' : 'asc'))"
        >
            <Icon v-if="sortBy != null" icon="bxs:down-arrow" class="h-3 w-3" />
            <span v-if="label">{{ label }}</span>
            <slot v-else />
        </div>
    </th>
</template>
