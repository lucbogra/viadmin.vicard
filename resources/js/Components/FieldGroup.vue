<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    id: String,
    placeholder: String,
    size: {
        type: String,
        default: 'default'
    },
    type: {
        type: String,
        default: 'text'
    },
    showLabel: {
        type: Boolean,
        default: true
    },
    desc: String,
    descType: {
        type: String,
        default: 'info'
    },
    required: {
        type: Boolean,
        default: true
    },
    model: {
        type: String,
        default: 1
    },
    inline: {
        type: Boolean,
        default: true
    },
    inputError: String,
});

</script>

<template>

    <div class="md:flex md:space-x-2 justify-between transition-all duration-300" v-if="inline">
        <div class="w-full md:w-[40%]" :class="model == 2 ? 'text-left' : 'text-right'">
            <InputLabel :error="inputError != null" :size="size" v-if="showLabel" :for="id" :value="placeholder" :required="required" />
        </div>
        <div class="flex-1">
            <slot v-bind="props" />
            <div v-if="desc" class="text-xs font-light text-gray-600">{{ desc }}</div>
            <InputError :message="inputError" class="mt-1" />
        </div>
    </div>

    <div v-else>
        <InputLabel :size="size" v-if="showLabel" :for="id" :value="placeholder" :required="required" />
        <slot v-bind="props" />

        <InputError :message="inputError" class="mt-1" />
    </div>

</template>
