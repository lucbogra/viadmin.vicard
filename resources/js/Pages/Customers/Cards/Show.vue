<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';
import Description from '@/Components/Description.vue';
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
    card: Object,
    customer: Object,
    filter: Object,
    breadcrumbs: Array,
});

const showModal = ref(false)
const selectedItem = ref(null)

const filterForm = buildFilterForm(props.filter);

watch(filterForm, debounce(term => {
    // handleFilter(route('customers.cards.index', {customer: props.customer.data}), filterForm);
}, 500))
</script>

<template>
    <AppLayout :title="$t('Card Requests')">
            
        <ProfileHeader :customer="customer.data" :breadcrumbs="breadcrumbs" :card="card.data" />
  
        <div class="my-6">

            
            <div class=" bg-white mx-10 py-10">
                <h5 class="mb-5 text-xl font-bold px-10">Card details</h5>
  
                <div class="grid grid-cols-3 gap-4 px-10">
                    <Description 
                        icon="f7:number"
                        title="Card Number"
                        :value="card.data.card_number"
                    />
                    <Description 
                        icon="f7:number"
                        title="Card Limit"
                        :value="card.data.card_limit.amount"
                    />
                    <Description 
                        icon="f7:number"
                        title="Daily Limit"
                        :value="card.data.daily_limit.amount"
                    />
                    <Description 
                        icon="f7:number"
                        title="Limit per transaction"
                        :value="card.data.per_transaction_limit.amount"
                    />
                    <Description 
                        icon="f7:number"
                        title="Card Fees"
                        :value="card.data.card_fees.amount"
                    />
                    <Description 
                        icon="f7:number"
                        title="Card Validity"
                        :value="card.data.card_validity.month"
                    />
                    <Description 
                        icon="f7:number"
                        title="Card Type"
                        :value="card.data.card_type"
                    />
                    <Description 
                        icon="f7:number"
                        title="Status"
                        :value="card.data.card_status"
                    />
                    <Description 
                        icon="f7:number"
                        title="Owner"
                        :value="card.data.owner?.name"
                    />
                </div>
                <!-- <pre>{{ card.data }}</pre> -->
            </div>
        </div>

        <!-- <ConfirmModal :showModal="showModal" :customer="customer.data" :card-request="selectedItem" @on-modal-close="showModal = false" /> -->
     
    </AppLayout>
</template>
