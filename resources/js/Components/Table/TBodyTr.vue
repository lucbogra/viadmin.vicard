<script setup>

const props =defineProps({
    additionalSlass: String,
});
</script>

<template>
    <thead>
        <tr class="cursor-pointer border-b" :class="additionalSlass">
            <slot />
        </tr>
    </thead>
</template>
