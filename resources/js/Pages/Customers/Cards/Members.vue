<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';
import ProfileHeader from '../ProfileHeader.vue';
import WithdrawModal from './WithdrawModal.vue';
import ActionLinkButton from '@/Components/ActionLinkButton.vue';
import CustomersIcon from '@/Components/Icons/customers.svg';
import ReceipJoinedModal from './ReceipJoinedModal.vue';
import EmptyIcon from '@/Components/Icons/empty.svg';
import MembersIcon from '@/Components/Icons/card-members.svg';
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
    members: Object,
    filter: Object,
    breadcrumbs: Array,
});

const showModal = ref(false)
const showJoinReceiptModal = ref(false)
const selectedLine = ref(null)

const filterForm = buildFilterForm(props.filter);

watch(filterForm, debounce(term => {
    handleFilter(route('customers.cards.members', {customer: props.customer.data, card: props.card.data}), filterForm);
}, 500))
</script>

<template>
    <AppLayout :title="$t('Card Requests')">
            
        <ProfileHeader :customer="customer.data" :breadcrumbs="breadcrumbs" :card="card.data" />
  
        <div class="my-6">

            
            <div class=" bg-white mx-10 py-10">
                <div class="flex justify-between px-10">
                    <h5 class="mb-5 text-xl font-bold">Card members</h5>
                    <!-- <h5 class="mb-5 text-xl font-bold px-3 py-1 rounded space-x-1 bg-gray-800">
                        <span class="text-gray-300">Balance: </span>
                        <span class="text-white">{{ card.data.card_balance.currency }}</span>
                        <span class="text-white">{{ card.data.card_balance.amount }}</span>
                    </h5> -->
                </div>
  
                <Table
                    :bordered="false"
                    :loading="tableLoading"
                    :items="members"
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
                            :icon="MembersIcon" 
                            :title="$t('Members')" 
                            :description="$t('Members')"
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
   
                            </div>
                        </div>
                    </template>

                    <template v-slot="{ items } = slotProps">
                        <THeadTr>
                            <THeadTd :label="$t('Avatar')" />
                            <THeadTd
                                :label="$t('Name')"
                                sort-by="name"
                                :current-sort-key="filterForm.sort"
                                :order-by="filterForm.order"
                                @on-sort="
                                    (sort, order) => (
                                        (filterForm.sort = sort),
                                        (filterForm.order = order)
                                    )
                                "
                            />
                            <THeadTd 
                                :label="$t('Email')"
                                sort-by="email"
                                :current-sort-key="filterForm.sort"
                                :order-by="filterForm.order"
                                @on-sort="
                                    (sort, order) => (
                                        (filterForm.sort = sort),
                                        (filterForm.order = order)
                                    )
                                "
                            />
                            <THeadTd :label="$t('Role')" />
                            <THeadTd :label="$t('Date')" />
                            <THeadTd :label="$t('Cards')" />
                            <THeadTd :label="$t('actions')" position="end"
                            />
                        </THeadTr>

                        <TBodyTr v-for="(member, index) of items" :key="index">
                            <TBodyTd>
                                <Avatar :image="member.avatar" icon="bx:user" />    
                            </TBodyTd>
                            <TBodyTd>
                                <div class="flex items-center space-x-1">
                                    <span style="font-size: .7em;" class="w-5 h-5 rounded-full bg-orange-400 text-white inline-flex justify-center items-center" v-if="member?.notifs?.total_notifs">
                                        {{ member.notifs.total_notifs }}
                                    </span>
                                    <span>{{ member.name }}</span>
                                </div>
                            </TBodyTd>
                            <TBodyTd :label="member.email" />
                            <TBodyTd :label="member.role?.name" />
                            <TBodyTd :label="member?.created_at?.formatted" />
                            <TBodyTd>
                                <div v-if="member?.card_counts" class="flex items-center space-x-1">
                                    <Icon icon="iconoir:credit-cards" class="w-4 h-4" />
                                    <span>{{ member?.card_counts }}</span>
                                </div>
                            </TBodyTd>
                            <TBodyTd class="space-x-1 flex justify-end">

                                <ActionLinkButton action="show" :href="route('customers.show', member)" />
                            
                            </TBodyTd>
                        </TBodyTr>
                    </template>
                </Table>
            </div>
        </div>

        <!-- <WithdrawModal :showModal="showModal" :merchants="merchants" :customer="customer.data" :card="card.data" @on-modal-close="showModal = false" />
        <ReceipJoinedModal :showModal="showJoinReceiptModal" @on-modal-close="showJoinReceiptModal = false, selectedLine = null" :card="card.data" :item="selectedLine" /> -->

    </AppLayout>
</template>
