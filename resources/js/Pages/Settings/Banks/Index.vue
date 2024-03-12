<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';
import ActionLinkButton from '@/Components/ActionLinkButton.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import EmptyIcon from '@/Components/Icons/empty.svg';
import NoBankIcon from '@/Components/Icons/no-bank.svg';
// import CustomersIcon from '@/Components/Icons/customers.svg';
// import BanksIcon from '@/Components/Icons/banks.svg';
import debounce from 'lodash/debounce';
import { Icon } from '@iconify/vue';
import { ref, watch } from 'vue';
import { EmptyData, handleFilter, buildFilterForm, tableLoading } from "@/Components/Table";
import { useForm, usePage } from '@inertiajs/vue3';
import { ElMessage } from 'element-plus';

const props = defineProps({
    banks: Object,
    filter: Object,
    breadcrumbs: Array,
});

const showConfirmModal = ref(false)
const selectedItem = ref(null)

const filterForm = buildFilterForm(props.filter);

watch(filterForm, debounce(term => {
    handleFilter(route('settings.banks.index'), filterForm);
}, 500))

const copy = (id) => {
    let testingCodeToCopy = document.querySelector(id)
    // alert(testingCodeToCopy.innerHTML)

    // testingCodeToCopy.select()
    // testingCodeToCopy.innerHTML.setSelectionRange(0, 99999)
    
    // document.execCommand('copy');
}

const deleteForm = useForm({
    _method: "DELETE"
});

const handleDelete = () => {

    if(selectedItem.value) {

        let url = route('settings.banks.destroy', {bank: selectedItem.value})        
    
        deleteForm.post(url, {
            preserveState: true,
            onSuccess: () => {
                if (usePage().props?.flash?.warning) {
                    
                    ElMessage.warning(usePage().props?.flash?.warning)
                    
                }
    
                if (usePage().props?.flash?.success) {

                    ElMessage.success(usePage().props?.flash?.success)
                    
                }
    
                selectedItem.value = null
                showConfirmModal.value = false
            },
            onError: () => {},
        })

    }

}
</script>

<template>
    <AppLayout :title="$t('Bank Lists')" :breadcrumbs="breadcrumbs">
              
        <div class="my-6">
    
            <div class="flex flex-col items-center justify-center" v-if="!filter.filtred && !banks.data.length">
    
                <EmptyData 
                            :icon="NoBankIcon" 
                            :title="$t('Bank Accounts')" 
                            :description="$t('Manage Your Banks Account')"
                            :buttonText="$t('Add a Bank')"
                            buttonIcon="mdi:bank-add"
                            :buttonLink="route('settings.banks.create')"     
                        />
            </div>

            <div v-else class="space-y-4 mx-10 p-10">
                <div class="flex">
                    <el-input
                        v-model="filterForm.search"
                        class="h-10 flex-1"
                        :placeholder="$t('Search...')"
                        clearable
                    />
                    <LinkButton
                        class="px-3 ml-4"
                        :outline="true"
                        type="link"
                        :href="route('settings.banks.create')"
                    >
                        <div class="flex items-center space-x-2">
                            <Icon icon="mdi:bank-add" class="h-4 w-4" />
                            <span>{{ $t('Add a Bank') }}</span>
                        </div>
                    </LinkButton>
                </div>
                <div v-for="(bank, index) of banks.data" :key="index" class="border py-5 px-5 rounded-lg flex bg-white relative">
                    <div class="absolute right-0 top-0 h-full p-10">
                        <div class="flex items-center space-x-1 h-full">
                            <ActionLinkButton action="edit" :href="route('settings.banks.edit', bank)" />
                            <ActionLinkButton action="delete" type="button" @click="selectedItem = bank, showConfirmModal = true" />
                        </div>
                    </div>
                    <div class="border-r px-8 flex justify-center items-center">
                        <Icon icon="clarity:bank-line" class="w-16 h-16" />
                    </div>
                    <div class="ml-6 flex-1 px-8 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col uppercase text-gray-500">
                                <span class="text-xs flex space-x-1">
                                    <Icon icon="clarity:bank-line" class="w-4 h-4" />
                                    <span>{{ $t('Bank Name') }}</span>
                                </span>
                                <span class="font-normal text-sm flex space-x-1">
                                    <span :id="`bank_name-${index}`">{{ bank.bank_name }}</span>
                                    <span class="rounded-full w-6 h-6 flex items-center justify-center cursor-pointer" 
                                        @click="copy(`#bank_name-${index}`)" 
                                        :title="$t('Copy')">
                                        <Icon icon="akar-icons:copy" class="w-4 h-4" />
                                    </span>
                                </span>
                            </div>
                            <div class="flex flex-col uppercase text-gray-500">
                                <span class="text-xs flex space-x-1">
                                    <Icon icon="ant-design:number-outlined" class="w-4 h-4" />
                                    <span>{{ $t('IBAN') }}</span>
                                </span>
                                <span class="font-normal text-sm flex space-x-1">
                                    <span :id="`iban-${index}`">{{ bank.iban }}</span>
                                    <span class="rounded-full w-6 h-6 flex items-center justify-center cursor-pointer" 
                                        @click="copy(`#iban-${index}`)" 
                                        :title="$t('Copy')">
                                        <Icon icon="akar-icons:copy" class="w-4 h-4" />
                                    </span>
                                </span>
                            </div>

                            <div class="flex flex-col uppercase text-gray-500">
                                <span class="text-xs flex space-x-1">
                                    <Icon icon="ph:user" class="w-4 h-4" />
                                    <span>{{ $t('Owner name') }}</span>
                                </span>
                                <span class="font-normal text-sm flex space-x-1">
                                    <span :id="`owner_name-${index}`">{{ bank.owner_name }}</span>
                                    <span class="rounded-full w-6 h-6 flex items-center justify-center cursor-pointer" 
                                        @click="copy(`#owner_name-${index}`)" 
                                        :title="$t('Copy')">
                                        <Icon icon="akar-icons:copy" class="w-4 h-4" />
                                    </span>
                                </span>
                            </div>
                            <div class="flex flex-col uppercase text-gray-500">
                                <span class="text-xs flex space-x-1">
                                    <Icon icon="mdi:address-marker-outline" class="w-4 h-4" />
                                    <span>{{ $t('address') }}</span>
                                </span>
                                <span class="font-normal text-sm flex space-x-1">
                                    <span :id="`address-${index}`">{{ bank.address }}</span>
                                    <span class="rounded-full w-6 h-6 flex items-center justify-center cursor-pointer" 
                                        @click="copy(`#address-${index}`)" 
                                        :title="$t('Copy')">
                                        <Icon icon="akar-icons:copy" class="w-4 h-4" />
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div v-if="bank.meta?.bank_branch" class="flex flex-col uppercase text-gray-500">
                                <span class="text-xs flex space-x-1">
                                    <Icon icon="icon-park-outline:branch-one" class="w-4 h-4" />
                                    <span>{{ $t('Bank Branch') }}</span>
                                </span>
                                <span class="font-normal text-sm flex space-x-1">
                                    <span :id="`bank_branch-${index}`">{{ bank.meta?.bank_branch }}</span>
                                    <span class="rounded-full w-6 h-6 flex items-center justify-center cursor-pointer" 
                                        @click="copy(`#bank_branch-${index}`)" 
                                        :title="$t('Copy')">
                                        <Icon icon="akar-icons:copy" class="w-4 h-4" />
                                    </span>
                                </span>
                            </div>
                            <div v-if="bank.meta?.owner_account" class="flex flex-col uppercase text-gray-500">
                                <span class="text-xs flex space-x-1">
                                    <Icon icon="fluent:contact-card-16-regular" class="w-4 h-4" />
                                    <span>{{ $t('Owner Account') }}</span>
                                </span>
                                <span class="font-normal text-sm flex space-x-1">
                                    <span :id="`owner_account-${index}`">{{ bank.meta?.owner_account }}</span>
                                    <span class="rounded-full w-6 h-6 flex items-center justify-center cursor-pointer" 
                                        @click="copy(`#owner_account-${index}`)" 
                                        :title="$t('Copy')">
                                        <Icon icon="akar-icons:copy" class="w-4 h-4" />
                                    </span>
                                </span>
                            </div>
                            <div v-if="bank.meta?.reference_number" class="flex flex-col uppercase text-gray-500">
                                <span class="text-xs flex space-x-1">
                                    <Icon icon="carbon:notebook-reference" class="w-4 h-4" />
                                    <span>{{ $t('Reference Number') }}</span>
                                </span>
                                <span class="font-normal text-sm flex space-x-1">
                                    <span :id="`reference_number-${index}`">{{ bank.meta?.reference_number }}</span>
                                    <span class="rounded-full w-6 h-6 flex items-center justify-center cursor-pointer" 
                                        @click="copy(`#reference_number-${index}`)" 
                                        :title="$t('Copy')">
                                        <Icon icon="akar-icons:copy" class="w-4 h-4" />
                                    </span>
                                </span>
                            </div>
                            <div v-if="bank.meta?.swift_address" class="flex flex-col uppercase text-gray-500">
                                <span class="text-xs flex space-x-1">
                                    <Icon icon="fluent-mdl2:input-address" class="w-4 h-4" />
                                    <span>{{ $t('Swift Address') }}</span>
                                </span>
                                <span class="font-normal text-sm flex space-x-1">
                                    <span :id="`swift_address-${index}`">{{ bank.meta?.swift_address }}</span>
                                    <span class="rounded-full w-6 h-6 flex items-center justify-center cursor-pointer" 
                                        @click="copy(`#swift_address-${index}`)" 
                                        :title="$t('Copy')">
                                        <Icon icon="akar-icons:copy" class="w-4 h-4" />
                                    </span>
                                </span>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>
        

        <ConfirmationModal max-width="sm" :show="showConfirmModal" @close="showConfirmModal = false">
                <template #title>
                    {{ $t("Confirm") }}
                </template>

                <template #content>
                    {{ $t("Are You Sure To Delete This Bank: \":bank\"?", {bank: selectedItem.bank_name}) }}
                </template>

                <template #footer>
                    <div class="flex space-x-2">
                        <LinkButton class="px-4 py-2 space-x-2" theme="danger" type="button" :processing="deleteForm.processing" @click="handleDelete">
                            <span>{{ $t("Yes, delete it") }}</span>
                        </LinkButton>                       

                        <LinkButton class="px-4 py-2" theme="secondary" type="button" @click="showConfirmModal = false">
                            {{ $t('Cancel') }}
                        </LinkButton>
                    </div>
                    
                </template>
            </ConfirmationModal>
        <!-- <ConfirmModal :showModal="showModal" :customer="customer.data" :card-request="selectedItem" @on-modal-close="showModal = false" /> -->
     
    </AppLayout>
</template>
