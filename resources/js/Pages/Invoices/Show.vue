<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';
import ActionLinkButton from '@/Components/ActionLinkButton.vue';
import InvoiceTemplate from '@/Components/InvoiceTemplate.vue';
import { Icon } from '@iconify/vue';

const props = defineProps({
    breadcrumbs: Array,
    invoice: Object
});

</script>

<template>

    <AppLayout title="Invoice" :breadcrumbs="breadcrumbs">

        <div class="my-6 mx-10">
    
            <div class="p-10 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white space-y-4">

                <InvoiceTemplate :invoice="invoice.data" />
              
            </div>
        </div>
        
    </AppLayout>

    
</template>
