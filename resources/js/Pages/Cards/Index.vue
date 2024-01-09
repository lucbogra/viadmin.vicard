<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';
import BankCard2 from '@/Components/BankCard2.vue';
// import RequestsIcon from '@/Components/Icons/requests.svg';
// import EmptyIcon from '@/Components/Icons/empty.svg';
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
    cards: Object,
    filter: Object,
});

const showModal = ref(false)
const selectedRequest = ref(null)

const filterForm = buildFilterForm(props.filter);

watch(filterForm, debounce(term => {
    handleFilter(route('cards.index'), filterForm);
}, 500))

</script>

<template>
    <AppLayout title="Cards" :breadcrumbs="breadcrumbs">

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white space-y-4">

                <div class="flex">
                    <el-input
                        v-model="filterForm.search"
                        class="h-14"
                        :placeholder="$t('Search...')"
                        clearable
                    />
                </div>

                <div class="grid grid-cols-3 gap-6">
                
                    <BankCard2 v-for="card of cards.data" :key="card.id" :card="card" />
                    
                </div>
            </div>
        </div>

        <!-- <FormModal :showModal="showModal" @on-modal-close="showModal = false" /> -->
        
    </AppLayout>
</template>
