<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';
import ActionLinkButton from '@/Components/ActionLinkButton.vue';
import RequestsIcon from '@/Components/Icons/invoices.svg';
import EmptyIcon from '@/Components/Icons/empty.svg';
import { Icon } from '@iconify/vue';
import debounce from 'lodash/debounce';
import { ref, watch } from 'vue';
import {
    Table,
    THeadTr,
    THeadTd,
    TBodyTr,
    TBodyTd,
    EmptyData,
    handleFilter,
    buildFilterForm,
    tableLoading
} from "@/Components/Table";
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    breadcrumbs: Array,
    invoices: Object,
    filter: Object,
});

const showModal = ref(false)
const selectedLine = ref(null)

const filterForm = buildFilterForm(props.filter);

watch(filterForm, debounce(term => {
    handleFilter(route('invoices.index'), filterForm);
}, 500))

</script>

<template>

    <AppLayout title="Invoices" :breadcrumbs="breadcrumbs">

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden">
                    
                    <Table
                        :loading="tableLoading"
                        :items="invoices"
                        :per-page="filterForm.per_page"
                        @update-per-page="
                            (newValue) => (filterForm.per_page = newValue)
                        "
                    >
                        <template #empty>

                            <EmptyData v-if="filter.filtred" 
                                :icon="EmptyIcon" 
                                :title="$t('Results')" 
                                :description="$t('Nothing Found')"
                                :button-text="$t('Back to the lists')" 
                                :button-link="route('invoices.index')" 
                            />

                            <EmptyData v-else
                                :icon="RequestsIcon" 
                                :title="$t('Invoice Lists')" 
                                :description="$t('Invoice Lists')" 
                                :showButton="false"
                            />

                        </template>

                        <template #search>
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="flex-1">
                                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 gap-2">
                                        
                                        <div class="h-10">
                                            <el-select v-model="filterForm.status" placeholder="Filter by status" size="large" class="w-28">
                                                <el-option :value="null" label="Status *" />
                                                <el-option value="paid" label="Paid" />
                                                <el-option value="unpaid" label="Unpaid" />
                                            </el-select>
                                        </div>
                                        
                                        <div class="h-10 flex-1 w-full">
                                            <el-input v-model="filterForm.search" placeholder="Search" size="large" />
                                        </div>
                        
                                    </div>
                                </div>
                            </div>
                        </template>

                        <template v-slot="{ items } = slotProps">
                            <THeadTr>
                                <THeadTd :label="$t('Customer')" />
                                <THeadTd :label="$t('Inv N°')" />
                                <THeadTd :label="$t('Month')" />
                                <THeadTd :label="$t('Cards')" />
                                <THeadTd :label="$t('Total Amount')" />
                                <THeadTd :label="$t('Status')" />
                                <THeadTd :label="$t('Billed at')" />
                                <THeadTd :label="$t('actions')" position="end" />
                            </THeadTr>

                            <TBodyTr v-for="(invoice, index) of items" :key="index">
                                <TBodyTd :label="invoice?.customer?.name" bold />
                                <TBodyTd :label="invoice?.invoice_number" bold />

                                <TBodyTd>
                                    <h1 class="flex items-center space-x-1 text-gray-500 font-semibold">
                                        <Icon icon="gravity-ui:calendar" class="w-4 h-4" />
                                        <span>{{ invoice.period?.formatted }}</span>
                                    </h1>
                                </TBodyTd>

                                <TBodyTd>
                                    <div v-if="invoice?.billed_cards?.length" class="flex items-center space-x-1">
                                        <Icon icon="iconoir:credit-cards" class="w-4 h-4" />
                                        <span>{{ invoice?.billed_cards?.length }}</span>
                                    </div>
                                </TBodyTd>

                                <TBodyTd>
                                    <span>{{ invoice?.amount.currency }} {{ invoice?.amount.amount }}</span>
                                </TBodyTd>
                                <!-- <pre>{{ invoice.period?.formatted }}</pre> -->

                                <TBodyTd>
                                    <span class="py-1 px-2 border rounded text-xs" 
                                            :class="{
                                            'border-green-400 bg-green-100 text-green-600': invoice.paid_at?.original,
                                            'border-red-400 bg-red-100 text-red-600': !invoice.paid_at?.original,
                                        }">
                                        <span v-if="invoice.paid_at?.formatted">Paid</span>
                                        <span v-else>Unpaid</span>
                                    </span>
                                </TBodyTd>

                                <TBodyTd :label="invoice?.created_at?.formatted" />

                                <TBodyTd class="space-x-1 flex justify-end">

                                    <ActionLinkButton title="Show invoice" action="show" :href="route('invoices.show', {invoice: invoice.id})" />
                                
                                </TBodyTd>
                            </TBodyTr>
                        </template>
                    </Table>


                    
                </div>
            </div>
        </div>

        <!-- <FormModal :showModal="showModal" @on-modal-close="showModal = false" /> -->
        
    </AppLayout>

    
</template>
