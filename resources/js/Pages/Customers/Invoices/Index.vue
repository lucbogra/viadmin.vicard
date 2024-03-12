<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';
import ProfileHeader from '../ProfileHeader.vue';
import InvoiceModal from './InvoiceModal.vue';
import ActionLinkButton from '@/Components/ActionLinkButton.vue';
import EmptyIcon from '@/Components/Icons/empty.svg';
import InvoiceIcon from '@/Components/Icons/wallet-add.svg';
import debounce from 'lodash/debounce';
import { Icon } from '@iconify/vue';
import Avatar from '@/Components/Avatar.vue';
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

const props = defineProps({
    invoices: Object,
    customer: Object,
    filter: Object,
    breadcrumbs: Array,
});

const mode = ref(null)
const showModal = ref(false)
const selectedItem = ref(null)

const filterForm = buildFilterForm(props.filter);

watch(filterForm, debounce(term => {
    handleFilter(route('customers.invoices.index', {customer: props.customer.data}), filterForm);
}, 500))
</script>

<template>
    <AppLayout :title="$t('Invoices')">
            
        <ProfileHeader :customer="customer.data" :breadcrumbs="breadcrumbs" />
  
        <div class="my-6">
    
            <div class=" bg-white mx-10 py-5">

                <h5 class="text-xl font-bold px-10">Invoice Lists</h5>
    
                <Table
                    :loading="tableLoading"
                    :bordered="false"
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
                            :description="$t('There Is No Invoice Found')"
                            :showButton="false"
                        />

                        <EmptyData v-else
                            :icon="InvoiceIcon" 
                            :title="$t('Invoice Lists')" 
                            :description="$t('There Is No Invoice')"
                            :showButton="false"
                        />

                    </template>

                    <template #search>
                        <div class="flex items-center space-x-4 mb-6 px-10">
                            <div class="flex-1">
                                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0">
            
                                    <!-- <div class="h-10 flex-1 w-full">
                                        <el-select v-model="filterForm.status" placeholder="Filter by status" size="normal" class="w-28">
                                            <el-option :value="null" label="Status *" />
                                            <el-option value="pending" label="Pending" />
                                            <el-option value="validated" label="Validated" />
                                            <el-option value="cancelled" label="Cancelled" />
                                        </el-select>
                                    </div> -->
                    

                                </div>
                            </div>
                        </div>
                    </template>

                    <template v-slot="{ items } = slotProps">
                        <THeadTr>
                            <THeadTd :label="$t('Month')" />
                            <THeadTd :label="$t('Cards')" />
                            <THeadTd :label="$t('Total Amount')" />
                            <THeadTd :label="$t('Status')" />
                            <THeadTd :label="$t('Billed at')" />
                            <THeadTd :label="$t('actions')" position="end"
                            />
                        </THeadTr>

                        <TBodyTr v-for="(invoice, index) of items" :key="index">
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
                                    <span v-else>Not Paid</span>
                                </span>
                            </TBodyTd>

                            <TBodyTd :label="invoice?.created_at?.formatted" />

                            <TBodyTd class="space-x-1 flex justify-end">

                                <ActionLinkButton title="Show invoice" button-icon="uil:invoice" action="show" type="button" @click="selectedItem = invoice, showModal = true" />
                            
                            </TBodyTd>
                        </TBodyTr>
                    </template>
                </Table>
                
            </div>
        </div>

        <InvoiceModal :showModal="showModal" :customer="customer.data" :invoice="selectedItem" @on-modal-close="showModal = false" />
     
    </AppLayout>
</template>
