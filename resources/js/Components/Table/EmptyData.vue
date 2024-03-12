<script setup>
import LinkButton from '@/Components/LinkButton.vue';
import { Icon } from '@iconify/vue';

defineProps({
    icon: String,
    title: String,
    description: String,
    buttonText: String,
    buttonIcon: String,
    buttonLink: String,
    showButton: {
        default: true,
        type: Boolean
    },
});
</script>

<template>

    <div class="py-16 w-full flex flex-col justify-center items-center">
        <div class="h-52 w-52 border-4 border-gray-100 flex justify-center items-center rounded-full">
            <img :src="icon" class="h-36 w-36" />
        </div>
        <div class="mt-6 text-2xl text-primary-900 font-bold">
            {{ title ?? $t("Resultats de la recherche") }}
        </div>
        <div class="text-gray-500">
            {{ description }}
        </div>
        <div class="mt-6" v-if="showButton">
            <LinkButton class="px-5 py-3 space-x-2" :outline="true" type="link" :href="buttonLink">
                <Icon v-if="buttonIcon" :icon="buttonIcon" class="h-4 w-4" />
                <span>{{ buttonText }}</span>
            </LinkButton>
        </div>
    </div>
    
</template>
