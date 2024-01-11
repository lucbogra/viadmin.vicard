<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';
import ProfileHeader from '../ProfileHeader.vue';
import WithdrawModal from './WithdrawModal.vue';
import ActionLinkButton from '@/Components/ActionLinkButton.vue';
import CustomersIcon from '@/Components/Icons/customers.svg';
import EmptyIcon from '@/Components/Icons/empty.svg';
import TransactionsIcon from '@/Components/Icons/card-transactions.svg';
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
    card: Object,
    customer: Object,
    transactions: Object,
    filter: Object,
    breadcrumbs: Array,
});

const showModal = ref(false)
const selectedItem = ref(null)

const filterForm = buildFilterForm(props.filter);

watch(filterForm, debounce(term => {
    handleFilter(route('customers.cards.transactions', {customer: props.customer.data, card: props.card.data}), filterForm);
}, 500))
</script>

<template>
    <AppLayout :title="$t('Card Requests')">
            
        <ProfileHeader :customer="customer.data" :breadcrumbs="breadcrumbs" :card="card.data" />
  
        <div class="my-6">

            
            <div class=" bg-white mx-10 py-10">
                <h5 class="mb-5 text-xl font-bold px-10">Card Transactions</h5>
  
                <Table
                    :bordered="false"
                    :loading="tableLoading"
                    :items="transactions"
                    :per-page="filterForm.per_page"
                    @update-per-page="
                        (newValue) => (filterForm.per_page = newValue)
                    "
                >
                    <template #empty>

                        <EmptyData v-if="filter.filtred" 
                            :icon="EmptyIcon" 
                            :title="$t('Results')" 
                            :description="$t('There Is No Transaction Found')"
                            :showButton="false"
                        />

                        <EmptyData v-else
                            :icon="TransactionsIcon" 
                            :title="$t('Transactions')" 
                            :description="$t('Transactions')"
                            :showButton="false"
                        />

                    </template>

                    <template #search>
                        <div class="flex items-center space-x-4 mb-6 px-10">
                            <div class="flex-1">
            
                                <div class="h-10 flex-1 w-full flex space-x-2">
                                    <el-select v-model="filterForm.type" placeholder="Type" size="normal" class="w-32">
                                        <el-option :value="null" label="Type *" />
                                        <el-option value="deposit" label="Deposit" />
                                        <el-option value="withdraw" label="Withdraw" />
                                    </el-select>

                                    <el-select v-model="filterForm.method" placeholder="Method" size="normal" class="w-32">
                                        <el-option :value="null" label="Method *" />
                                        <el-option value="commission" label="Commission" />
                                        <el-option value="bank transfer" label="Bank Transfer" />
                                    </el-select>
                                </div>
                    
                            </div>
                            <div>
                                <LinkButton
                                    class="px-3 py-2 ml-4 flex"
                                    :outline="true"
                                    type="button"
                                    @click="showModal = true"
                                >
                                    <div class="flex items-center space-x-2">
                                        <Icon icon="mynaui:credit-card-minus" class="h-4 w-4" />
                                        <span>{{ $t("New withdraw") }}</span>
                                    </div>
                                </LinkButton>
                            </div>
                        </div>
                    </template>

                    <template v-slot="{ items } = slotProps">
                        <THeadTr>
                            <THeadTd :label="$t('Type')" />
                            <THeadTd :label="$t('Method')" />
                            <THeadTd :label="$t('Amount')" />
                            <THeadTd :label="$t('Date')" />
                            <THeadTd :label="$t('Perform By')" />
                        </THeadTr>

                        <TBodyTr v-for="(item, index) of items" :key="index">
                            <TBodyTd :label="item.type" class="uppercase" />
                            <TBodyTd :label="item.method" class="uppercase" />
                            <TBodyTd class="uppercase" bold>
                                <span :class="item.type == 'deposit' ? 'text-green-600' : 'text-red-600'">
                                    {{ item.type == 'deposit' ? '+' : '-' }}{{ item.amount.amount }}
                                </span>
                            </TBodyTd>
                            <TBodyTd :label="item?.date?.formatted" />
                            <TBodyTd :label="item.user?.name" class="uppercase" />

                        </TBodyTr>
                    </template>
                </Table>
            </div>
        </div>

        <WithdrawModal :showModal="showModal" :customer="customer.data" :card="card.data" @on-modal-close="showModal = false" />
     
    </AppLayout>
</template>
