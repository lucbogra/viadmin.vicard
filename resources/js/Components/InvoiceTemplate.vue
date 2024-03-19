<script setup>
import { Icon } from '@iconify/vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    invoice: Object,
});

</script>

<template>
    
    <div class="space-y-4">

        <div class="flex justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800">VICARD</h2>
                <span>+212767988</span>
            </div>
            <div>
                <h2 class="font-bold text-2xl text-gray-800">Invoice</h2>
                <table>
                    <tr>
                        <td class="text-sm text-gray-400">Invoice Number: </td>
                        <th class="text-right block"><span class="pl-4 text-right">{{ invoice?.invoice_number }}</span></th>
                    </tr>
                    <tr>
                        <td class="text-sm text-gray-400">Payment Status: </td>
                        <th class="text-right">
                            <span class="block w-full uppercase pl-4" 
                                    :class="{
                                    'text-green-600': invoice.status == 'paid',
                                    'text-orange-600': invoice.status == 'processing',
                                    'text-red-600': invoice.status == 'pending',
                                    'text-red-800': invoice.status == 'reject'
                                }">
                                <span style="font-size: .7em" class="inline-flex items-center space-x-1">
                                    <Icon icon="icomoon-free:hour-glass" v-if="invoice.status == 'processing'" class="w-3 h-3" />
                                    <Icon icon="mage:hour-glass" v-if="invoice.status == 'pending'" class="w-3 h-3" />
                                    <Icon icon="line-md:check-all" v-if="invoice.status == 'paid'" class="w-3 h-3" />
                                    <Icon icon="lucide:file-x-2" v-if="invoice.status == 'reject'" class="w-3 h-3" />
                                    <span>{{ invoice.payment_status }}</span>
                                </span>
                            </span>
                        </th>
                    </tr>
                    <tr v-if="invoice.paid_at?.original">
                        <td class="text-sm text-gray-400">Paid at</td>
                        <th class="text-right text-sm">{{ invoice.paid_at?.formatted }}</th>
                    </tr>
                    <tr v-if="invoice.paid_at?.original">
                        <td class="text-sm text-gray-400">Payment Method</td>
                        <th class="text-right text-sm">{{ invoice.payment_method }}</th>
                    </tr>
                </table>
            </div>
        </div>

        <div>
            <h4 class="font-bold">Paid by</h4>
            <p class="font-normal text-sm text-gray-400">{{ invoice?.customer?.name }}</p>
            <p class="font-normal text-sm text-gray-400">{{ invoice?.customer?.email }}</p>
        </div>

        <div>
            <h2 class="font-semibold text-gray-600 text-xl"><span>{{ invoice?.amount.currency }} {{ invoice?.amount.amount }}</span> paid for <span>{{ invoice.period?.formatted }}</span></h2>
        </div>
        <!-- <pre>{{ invoice }}</pre> -->
        <div>
            <table class="w-full">
                <thead>
                    <tr class="py-2 border-b bg-gray-200 uppercase font-normal">
                        <th class="text-md text-gray-500 font-semibold text-left py-2 px-4">Description</th>
                        <th class="text-md text-gray-500 font-semibold text-right py-2 px-4">Billed at</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <th class="text-sm text-gray-400 font-normal text-left py-2 px-4 uppercase">Card number: {{ invoice?.card?.card_number }}</th>
                        <th class="text-sm text-gray-400 font-normal text-right py-2 px-4">{{ invoice?.amount?.currency }} {{ invoice?.amount?.amount }}</th>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-md text-gray-400 font-normal py-2 px-4"></th>
                        <th class="text-md text-gray-400 font-normal py-2 px-4 bg-gray-200 uppercase">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Amount Paid</span>
                                <span class="text-md text-gray-900 font-semibold">{{ invoice?.amount?.currency }} {{ invoice?.amount?.amount }}</span>
                            </div>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
        
    </div>

</template>