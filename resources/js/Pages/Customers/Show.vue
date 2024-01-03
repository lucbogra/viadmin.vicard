<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProfileHeader from './ProfileHeader.vue';
import { Icon } from '@iconify/vue';

const props = defineProps({
    breadcrumbs: Array,
    customer: Array,
});

</script>

<template>
    <AppLayout :title="$t('Customer Profile')"> 
            
        <div class="">
            
            <ProfileHeader :customer="customer.data" :breadcrumbs="breadcrumbs" />

        </div>
     
    </AppLayout>
</template>
