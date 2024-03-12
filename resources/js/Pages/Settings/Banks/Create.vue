<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';
import FieldGroup from "@/Components/FieldGroup.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { Icon } from '@iconify/vue';
import { onMounted, ref, watch } from 'vue';
import { ElMessage } from 'element-plus';

const props = defineProps({
    breadcrumbs: Array,
    bank: Object
});

const form = useForm({
    _method: "POST",
    owner_name: props.bank?.owner_name,
    bank_name: props.bank?.bank_name,
    iban: props.bank?.iban,
    address: props.bank?.address,

    owner_account: props.bank?.meta?.owner_account,
    swift_address: props.bank?.meta?.swift_address,
    bank_branch: props.bank?.meta?.bank_branch,
    reference_number: props.bank?.meta?.reference_number,
});

const submit = () => {

    let url = ""

    if (props.bank != "") {

        form._method = 'PUT'
        url = route('settings.banks.update', {bank: props.bank})        
    } else {

        form._method = 'POST'
        url = route('settings.banks.store')
    }

    form.post(url, {
        preserveState: true,
        onSuccess: () => {
            ElMessage.success(usePage().props?.flash?.success)
        },
        onError: () => {},
    })

}

</script>

<template>
    <AppLayout :title="$t('New Customer')" :breadcrumbs="breadcrumbs"> 
            
        <div class="">
            <form @submit.prevent="submit" class="bg-white mx-10 px-10 py-10 block space-y-6">
                <div class="flex flex-col justify-center items-center border py-4 bg-gray-50 rounded">
                    <Icon icon="clarity:bank-line" class="w-16 h-16 text-gray-500" />
                    <h4 class="font-bold text-gray-400 uppercase">{{ bank?.id ? $t('Edit Bank') : $t('New Bank') }}</h4>
                </div>
                <div class="grid grid-cols-2 gap-4">
     
                    <FieldGroup id="bank_name" :placeholder="$t('Bank name')" :input-error="form.errors.bank_name" v-slot="slotProps">
                        <el-input :placeholder="slotProps.placeholder" v-model="form.bank_name" class="w-full" size="large" />
                    </FieldGroup>

                    <FieldGroup id="iban" :placeholder="$t('Iban')" :input-error="form.errors.iban" v-slot="slotProps">
                        <el-input :placeholder="slotProps.placeholder" v-model="form.iban" class="w-full" size="large" />
                    </FieldGroup>

                    <FieldGroup id="owner_name" :placeholder="$t('Owner name')" :input-error="form.errors.owner_name" v-slot="slotProps">
                        <el-input :placeholder="slotProps.placeholder" v-model="form.owner_name" class="w-full" size="large" />
                    </FieldGroup>

                    <FieldGroup id="address" :placeholder="$t('Address')" :input-error="form.errors.address" v-slot="slotProps">
                        <el-input :placeholder="slotProps.placeholder" v-model="form.address" class="w-full" size="large" />
                    </FieldGroup>

                </div>

                <div class="grid grid-cols-2 gap-4">
     
                    <FieldGroup :required="false" id="owner_account" :placeholder="$t('Owner Account')" :input-error="form.errors.owner_account" v-slot="slotProps">
                        <el-input :placeholder="slotProps.placeholder" v-model="form.owner_account" class="w-full" size="large" />
                    </FieldGroup>

                    <FieldGroup :required="false" id="swift_address" :placeholder="$t('Swift Address')" :input-error="form.errors.swift_address" v-slot="slotProps">
                        <el-input :placeholder="slotProps.placeholder" v-model="form.swift_address" class="w-full" size="large" />
                    </FieldGroup>

                    <FieldGroup :required="false" id="bank_branch" :placeholder="$t('Bank Branch')" :input-error="form.errors.bank_branch" v-slot="slotProps">
                        <el-input :placeholder="slotProps.placeholder" v-model="form.bank_branch" class="w-full" size="large" />
                    </FieldGroup>

                    <FieldGroup :required="false" id="reference_number" :placeholder="$t('Reference Number')" :input-error="form.errors.reference_number" v-slot="slotProps">
                        <el-input :placeholder="slotProps.placeholder" v-model="form.reference_number" class="w-full" size="large" />
                    </FieldGroup>

                </div>

                <div>
                    <LinkButton class="px-5 py-2 space-x-2 mt-5 mb-2 md:w-auto w-full flex justify-center" :outline="true" type="submit" :processing="form.processing">
                        <span>{{ bank?.id ? $t("Update") : $t("Save") }}</span>
                        <template #icon>
                            <Icon icon="typcn:staff-add-outline" class="h-4 w-4" />
                        </template>
                    </LinkButton>
                </div>
        

            </form> 

        </div>
     
    </AppLayout>
</template>
