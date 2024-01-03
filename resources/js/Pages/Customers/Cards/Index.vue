<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';
import ProfileHeader from '../ProfileHeader.vue';
import ActionLinkButton from '@/Components/ActionLinkButton.vue';
import CustomersIcon from '@/Components/Icons/customers.svg';
import EmptyIcon from '@/Components/Icons/empty.svg';
import CardsIcon from '@/Components/Icons/cards.svg';
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
    cards: Object,
    customer: Object,
    filter: Object,
    breadcrumbs: Array,
});

const showModal = ref(false)
const selectedItem = ref(null)

const filterForm = buildFilterForm(props.filter);

watch(filterForm, debounce(term => {
    handleFilter(route('customers.card-requests.index', {customer: props.customer.data}), filterForm);
}, 500))
</script>

<template>
    <AppLayout :title="$t('Card Requests')">
            
        <ProfileHeader :customer="customer.data" :breadcrumbs="breadcrumbs" />
  
        <div class="my-6">
    
            <div class=" bg-white mx-10 p-10">
    
                <Table
                    :loading="tableLoading"
                    :items="cards"
                    :per-page="filterForm.per_page"
                    @update-per-page="
                        (newValue) => (filterForm.per_page = newValue)
                    "
                >
                    <template #empty>

                        <EmptyData v-if="filter.filtred" 
                            :icon="EmptyIcon" 
                            :title="$t('Results')" 
                            :description="$t('There Is No Card Found')"
                            :showButton="false"
                        />

                        <EmptyData v-else
                            :icon="CardsIcon" 
                            :title="$t('Card Request Lists')" 
                            :description="$t('There Is No Card')"
                            :showButton="false"
                        />

                    </template>

                    <template #search>
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="flex-1">
                                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0">
            
                                    <div class="h-10 flex-1 w-full">
                                        <el-select v-model="filterForm.status" placeholder="Filter by status" size="large">
                                            <el-option value="pending" label="Pending" />
                                            <el-option value="validated" label="Validated" />
                                            <el-option value="cancelled" label="Cancelled" />
                                        </el-select>
                                    </div>
                    

                                </div>
                            </div>
                        </div>
                    </template>

                    <template v-slot="{ items } = slotProps">
                        <THeadTr>
                            <THeadTd :label="$t('Owner')" />
                            <THeadTd :label="$t('Card Number')" />
                            <THeadTd :label="$t('Validity')" />
                            <THeadTd :label="$t('Type')" />
                            <THeadTd :label="$t('Balance')" />
                            <THeadTd :label="$t('Status')" />
                            <THeadTd :label="$t('Date')" />
                            <THeadTd :label="$t('actions')" position="end"
                            />
                        </THeadTr>

                        <TBodyTr v-for="(item, index) of items" :key="index">
                            <TBodyTd :label="item.owner?.name" />
                            <TBodyTd :label="item.card_number" />
                            <TBodyTd :label="item.card_validity.formatted" />
                            <TBodyTd :label="item.card_type" />
                            <TBodyTd :label="item.card_balance.amount" />
                            <TBodyTd>
                                <span style="font-size: .7em;" class="py-1 px-2 border rounded uppercase" 
                                        :class="{
                                        'border-green-400 bg-green-100 text-green-600': item.card_status == 'activated',
                                        'border-red-400 bg-red-100 text-red-600': item.card_status == 'frozen',
                                        'border-orange-400 bg-orange-100 text-orange-600': item.card_status == 'not activated',
                                    }">
                                    {{ item.card_status }}
                                </span>
                            </TBodyTd>
                            <TBodyTd :label="item?.created_at?.formatted" />
                            <TBodyTd class="space-x-1 flex justify-end">

                                <ActionLinkButton action="show" type="button" />
                            
                            </TBodyTd>
                        </TBodyTr>
                    </template>
                </Table>
                
            </div>
        </div>

        <ConfirmModal :showModal="showModal" :customer="customer.data" :card-request="selectedItem" @on-modal-close="showModal = false" />
     
    </AppLayout>
</template>
