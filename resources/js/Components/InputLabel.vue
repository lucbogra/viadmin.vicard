<script setup>
defineProps({
    error: String,
    value: String,
    size: {
        type: String,
        default: 'default'
    },
    required: {
        type: Boolean,
        default: true
    },
});
</script>

<template>
    <label class="font-light uppercase tracking-widest text-gray-900" 
            :class="{'text-xs': size == 'default'}"
            :style="size == 'small' ? 'font-size: .5em' : ''"
        >
        <span :class="{'border-b border-red-500 bg-red-50': error}">
            <span v-if="value">{{ value }}</span>
            <span v-else><slot /></span>
        </span>
        
        <span v-if="required" class="text-red-600 ml-1">*</span>
    </label>
</template>
