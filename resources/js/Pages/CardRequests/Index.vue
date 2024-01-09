<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';
import DetailModal from '../Customers/CardRequests/DetailModal.vue';
import ConfirmModal from '../Customers/CardRequests/ConfirmModal.vue';
import RequestsIcon from '@/Components/Icons/wallet-add.svg';
import ActionLinkButton from '@/Components/ActionLinkButton.vue';
import EmptyIcon from '@/Components/Icons/empty.svg';
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
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    cardRequests: Object,
    filter: Object,
    breadcrumbs: Array,
});

const showModal = ref(false)
const modal = ref('form')
const selectedItem = ref(null)

const filterForm = buildFilterForm(props.filter);

watch(filterForm, debounce(term => {
    handleFilter(route('card-requests.index'), filterForm);
}, 500))
</script>

<template>
    <AppLayout :title="$t('Card Requests')">
              
        <div class="my-6">
    
            <div class=" bg-white mx-10 p-10">

                <h5 class="mb-5 text-xl font-bold">Card requests</h5>
    
                <Table
                    :bordered="false"
                    :loading="tableLoading"
                    :items="cardRequests"
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
                        <div class="flex items-center space-x-4 mb-6">
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
                            <THeadTd :label="$t('User')" />
                            <THeadTd :label="$t('Status')" />
                            <THeadTd :label="$t('Date')" />
                            <THeadTd :label="$t('actions')" position="end"
                            />
                        </THeadTr>

                        <TBodyTr v-for="(req, index) of items" :key="index">
                            <TBodyTd>
                                <Link class="hover:text-blue-600 hover:font-semibold" :href="route('customers.show', req.user)">{{ req.user.name }}</Link>
                            </TBodyTd>
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
                            <TBodyTd :label="req?.created_at?.formatted" />
                            <TBodyTd class="space-x-1 flex justify-end">

                                <ActionLinkButton v-if="req.status.key == 'pending'" action="edit" button-icon="mdi:list-status" type="button" @click="selectedItem = req, modal = 'form', showModal = true" />
                                <ActionLinkButton action="show" type="button" @click="selectedItem = req, modal = 'details', showModal = true" />
                            
                            </TBodyTd>
                        </TBodyTr>
                    </template>
                </Table>
                
            </div>
        </div>

        <DetailModal :showModal="showModal && modal == 'details'" :card-request="selectedItem" @on-modal-close="showModal = false" />
        <ConfirmModal :showModal="showModal && modal == 'form'" :customer="selectedItem?.user" :card-request="selectedItem" @on-modal-close="showModal = false" />
     
    </AppLayout>
</template>
