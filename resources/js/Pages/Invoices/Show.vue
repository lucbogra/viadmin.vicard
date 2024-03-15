<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';
import ActionLinkButton from '@/Components/ActionLinkButton.vue';
import InvoiceTemplate from '@/Components/InvoiceTemplate.vue';
import { Icon } from '@iconify/vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ElMessage } from 'element-plus';

const props = defineProps({
    breadcrumbs: Array,
    invoice: Object
});

const form = useForm({
    _method: "PUT",
    action: "",
});

const submit = (action) => {

    if (confirm('Are you sure to continue this action ?')) {
        
        form._method = 'PUT'
        form.action = action
    
        form.post(route('invoices.update', {invoice: props.invoice.data, action: action}), {
            preserveState: true,
            onSuccess: () => {
                ElMessage.success(usePage().props?.flash?.success)
            },
            onError: () => {},
        })
    }

}
</script>

<template>

    <AppLayout title="Invoice" :breadcrumbs="breadcrumbs">

        <div class="my-6 mx-10 space-y-4">
    
            <div v-if="invoice.data.status == 'processing'" class="px-5 py-3 rounded border border-orange-500 text-orange-500 bg-orange-200">
                <div>
                    <p class="text-sm">This invoice is awaiting confirmation.</p>
                    <p class="text-xs">Please see receipts for confirmation</p>
                </div>
            </div>

            <div class="flex space-x-2" v-if="invoice.data.status == 'processing'">
                <LinkButton theme="success" class="px-5 py-2 space-x-2 md:w-auto w-full flex justify-center" :outline="true" @click="submit('paid')" :processing="form.processing && form.action == 'paid'">
                    <span>{{ $t("Confirm payment") }}</span>
                    <template #icon>
                        <Icon icon="line-md:check-all" class="h-4 w-4" />
                    </template>
                </LinkButton>

                <LinkButton theme="danger" class="px-5 py-2 space-x-2 md:w-auto w-full flex justify-center" :outline="true" @click="submit('reject')" :processing="form.processing && form.action == 'reject'">
                    <span>{{ $t("Reject payment") }}</span>
                    <template #icon>
                        <Icon icon="fluent-mdl2:receipt-undelivered" class="h-4 w-4" />
                    </template>
                </LinkButton>
            </div>

            <div class="" v-if="invoice.data?.payment_method == 'Bank Transfer' && invoice.data?.status != 'pending'">
                <h4 class="mb-2 text-xl underline text-gray-600">{{ $t("Receipts") }}</h4>
                <div v-for="(receipt, index) of invoice.data?.receips ?? []" :key="index">
                    <a target="_blank" class="flex items-center space-x-2 text-blue-600 hover:text-blue-900 hover:underline" :href="receipt.file">
                        <Icon icon="heroicons-solid:external-link" class="h-4 w-4" />
                        <span>{{ receipt.name }}</span>
                    </a>
                </div>
            </div>

            <div class="p-10 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white space-y-4">

                <InvoiceTemplate :invoice="invoice.data" />
              
            </div>
        </div>
        
    </AppLayout>

    
</template>
