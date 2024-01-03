<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';
import ActionLinkButton from '@/Components/ActionLinkButton.vue';
import CustomersIcon from '@/Components/Icons/customers.svg';
import EmptyIcon from '@/Components/Icons/empty.svg';
import debounce from 'lodash/debounce';
import { Icon } from '@iconify/vue';
import Avatar from '@/Components/Avatar.vue';
import { watch } from 'vue';
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
    customers: Object,
    filter: Object,
    breadcrumbs: Array,
});

const filterForm = buildFilterForm(props.filter);

watch(filterForm, debounce(term => {
    handleFilter(route('customers.index'), filterForm);
}, 500))
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

  
            
        <div class="mb-6">
    
            <div class=" bg-white mx-10 p-10">
    
                <Table
                    :loading="tableLoading"
                    :items="customers"
                    :per-page="filterForm.per_page"
                    @update-per-page="
                        (newValue) => (filterForm.per_page = newValue)
                    "
                >
                    <template #empty>

                        <EmptyData v-if="filter.filtred" 
                            :icon="EmptyIcon" 
                            :title="$t('Resultats de la recherche')" 
                            :description="$t('Aucun employé n\'a été trouver en fonction de votre recherche')"
                            :button-text="$t('Revenir à la liste')" 
                            :button-link="route('customers.index')" 
                        />

                        <EmptyData v-else
                            :icon="CustomersIcon" 
                            :title="$t('Customer Lists')" 
                            :description="$t('Manage Customers')"
                            button-icon="ci:user-add" 
                            :button-text="$t('Create The First Custmer')" 
                            :button-link="route('customers.create')" 
                        />

                    </template>

                    <template #search>
                        <div class="flex items-center space-x-4 mb-6" v-if="customers.data?.length">
                            <div class="flex-1">
                                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0">
                                    <LinkButton
                                        class="px-3 py-3 space-x-2 justify-center flex md:hidden"
                                        :outline="true"
                                        type="link"
                                        :href="route('customers.create')"
                                    >
                                        <Icon icon="mi:user-add" class="h-4 w-4" />
                                        <span>{{ $t("New Custmer") }}</span>
                                    </LinkButton>
                    
                                    <el-input
                                              :placeholder="$t('Search a customer...')"
                                              v-model="filterForm.search" 
                                              size="large"
                                              class="h-10 flex-1 w-full"
                                            >
                                        <template #append>
                                            <Icon icon="ant-design:search-outlined" />
                                        </template>
                                    </el-input>

                                    <LinkButton
                                        class="px-3 py-3 ml-4 hidden md:flex"
                                        :outline="true"
                                        type="link"
                                        :href="route('customers.create')"
                                    >
                                        <div class="flex items-center space-x-2">
                                            <Icon icon="mi:user-add" class="h-4 w-4" />
                                            <span>{{ $t("New Custmer") }}</span>
                                        </div>
                                    </LinkButton>

                                </div>
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
                            <THeadTd :label="$t('actions')" position="end"
                            />
                        </THeadTr>

                        <TBodyTr v-for="(customer, index) of items" :key="index">
                            <TBodyTd>
                                <Avatar :image="customer.avatar" icon="bx:user" />    
                            </TBodyTd>
                            <TBodyTd :label="customer.name" />
                            <TBodyTd :label="customer.email" />
                            <TBodyTd :label="customer.role?.name" />
                            <TBodyTd :label="customer?.created_at?.formatted" />
                            <TBodyTd class="space-x-1 flex justify-end">

                                <ActionLinkButton action="show" :href="route('customers.show', customer)" />
                                <ActionLinkButton action="delete" :href="route('customers.show', customer)" />
                            
                            </TBodyTd>
                        </TBodyTr>
                    </template>
                </Table>
            </div>
        </div>>
     
    </AppLayout>
</template>
