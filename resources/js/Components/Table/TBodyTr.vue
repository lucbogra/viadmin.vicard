<script setup>

const props =defineProps({
    additionalSlass: String,
});
</script>

<template>
    <thead>
        <tr class="cursor-pointer border-b border-gray-200" :class="additionalSlass">
            <slot />
        </tr>
    </thead>
</template>
