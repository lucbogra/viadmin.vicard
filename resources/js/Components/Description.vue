<script setup>
import { Icon } from '@iconify/vue';
import { computed } from 'vue';

const props = defineProps({
    id: String,
    icon: String,
    title: String,
    value: String,
    canCopy: Boolean,
    inline: Boolean,
});

const generateRandomString = (length = 15) => {
    const charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    let randomString = "";

    for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * charset.length);
        randomString += charset.charAt(randomIndex);
    }

    return randomString;
}

const elId = computed(() => {
    return props.id ?? generateRandomString();
})
</script>

<template>
    <div class="flex uppercase text-gray-500" :class="inline ? 'justify-between items-center' : 'flex-col'">
        <span class="text-xs flex space-x-1">
            <Icon v-if="icon" :icon="icon" class="w-4 h-4" />
            <span>{{ title }}</span>
        </span>
        <span class="font-normal text-sm flex space-x-1">
            <span :id="`${elId}`">{{ value }}</span>
            <span v-if="canCopy" class="rounded-full w-6 h-6 flex items-center justify-center cursor-pointer" 
                @click="copy(`#${elId}`)" 
                :title="$t('Copy')">
                <Icon icon="akar-icons:copy" class="w-4 h-4" />
            </span>
        </span>
    </div>
</template>
