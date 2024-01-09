<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';
import ConfirmModal from '../Customers/CardTopupRequests/ConfirmModal.vue';
import ActionLinkButton from '@/Components/ActionLinkButton.vue';
import EmptyIcon from '@/Components/Icons/empty.svg';
import RequestsIcon from '@/Components/Icons/wallet-add.svg';
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
    cardTopupRequests: Object,
    filter: Object,
    breadcrumbs: Array,
});

const mode = ref(null)
const showModal = ref(false)
const selectedItem = ref(null)

const filterForm = buildFilterForm(props.filter);

watch(filterForm, debounce(term => {
    handleFilter(route('customers.topup-requests.index', {customer: props.customer.data}), filterForm);
}, 500))
</script>

<template>
    <AppLayout :title="$t('Card Requests')">
              
        <div class="my-6">
    
            <div class=" bg-white mx-10 py-10">

                <h5 class="mb-5 text-xl font-bold px-10">TopUp requests</h5>
    
                <Table
                    :loading="tableLoading"
                    :bordered="false"
                    :items="cardTopupRequests"
                    :per-page="filterForm.per_page"
                    @update-per-page="
                        (newValue) => (filterForm.per_page = newValue)
                    "
                >
                    <template #empty>

                        <EmptyData v-if="filter.filtred" 
                            :icon="EmptyIcon" 
                            :title="$t('Results')" 
                            :description="$t('There Is No Card Request Found')"
                            :showButton="false"
                        />

                        <EmptyData v-else
                            :icon="RequestsIcon" 
                            :title="$t('Card Request Lists')" 
                            :description="$t('There Is No Card Request')"
                            :showButton="false"
                        />

                    </template>

                    <template #search>
                        <div class="flex items-center space-x-4 mb-6 px-10">
                            <div class="flex-1">
                                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0">
            
                                    <div class="h-10 flex-1 w-full">
                                        <el-select v-model="filterForm.status" placeholder="Filter by status" size="normal" class="w-28">
                                            <el-option :value="null" label="Status *" />
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
                            <THeadTd :label="$t('Card Infos')" />
                            <THeadTd :label="$t('Date')" />
                            <THeadTd :label="$t('Files')" />
                            <THeadTd :label="$t('Status')" />
                            <THeadTd :label="$t('actions')" position="end"
                            />
                        </THeadTr>

                        <TBodyTr v-for="(req, index) of items" :key="index">
                            <TBodyTd>
                                <div class="text-xs bg-gray-500 py-2 rounded text-white px-2 relative">
                                    <div class="absolute top-0 right-0 p-2">
                                        <Icon icon="solar:card-broken" class="h-6 w-6" />
                                        <!-- <Icon icon="flat-color-icons:sim-card-chip" class="h-10 w-10" /> -->
                                    </div>
                                    <h1 class="flex items-center space-x-1">
                                        <Icon icon="solar:card-broken" class="w-4 h-4" />
                                        <span>{{ req.card?.card_number }}</span>
                                    </h1>
                                    <h1 v-if="req.transaction" class="flex items-center space-x-1">
                                        <Icon icon="mynaui:credit-card-plus" class="w-4 h-4" />
                                        <span>{{ req.transaction.amount.amount }}</span>
                                    </h1>
                                    <h1 class="flex items-center space-x-1">
                                        <Icon icon="ph:user" class="w-4 h-4" />
                                        <span>{{ req.card?.owner?.name }}</span>
                                    </h1>
                                </div>
                            </TBodyTd>

                            <TBodyTd>
                                <span class="py-1 px-2 border rounded text-xs inline-flex" @click="selectedItem = req, showModal = true, mode = 'show'">
                                    <Icon icon="ic:baseline-attach-file" class="w-4 h-4" />
                                    <span>{{ req.attachments.length }} files</span>
                                </span>
                            </TBodyTd>

                            <TBodyTd :label="req?.created_at?.formatted" />

                            <TBodyTd>
                                <span class="py-1 px-2 border rounded text-xs" 
                                        :class="{
                                        'border-green-400 bg-green-100 text-green-600': req.status.key == 'validated',
                                        'border-red-400 bg-red-100 text-red-600': req.status.key == 'cancelled',
                                        'border-orange-400 bg-orange-100 text-orange-600': req.status.key == 'pending',
                                    }">
                                    {{ req.status.label }}
                                </span>
                            </TBodyTd>

                            <TBodyTd class="space-x-1 flex justify-end">

                                <ActionLinkButton v-if="req.status.key == 'pending'" title="Manage request" button-icon="ci:file-check" action="edit" type="button" @click="selectedItem = req, mode = null, showModal = true" />
                            
                            </TBodyTd>
                        </TBodyTr>
                    </template>
                </Table>
                
            </div>
        </div>

        <ConfirmModal :showModal="showModal" :customer="selectedItem?.user" :card-request="selectedItem" @on-modal-close="showModal = false" :mode="mode" />
     
    </AppLayout>
</template>
