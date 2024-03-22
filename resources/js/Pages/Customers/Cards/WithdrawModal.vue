<template>   
    <DialogModal :show="showModal" maxWidth="lg" @close="modalOnClose">

        <template #content>

            <div class="space-y-4 flex flex-col items-center">
                <h4 class="text-center font-semibold uppercase">{{ $t('Withdraw') }}</h4>

                <div class="w-24 h-24 flex justify-center items-center">
                    <img :src="RequestsIcon" class="h-16 w-16" />
                </div>              

                <div class="space-y-4">
                    <div class="space-y-4 rounded border p-6">

                        <FieldGroup :inline="true" id="amount" :placeholder="$t('Amount')" :input-error="form.errors.amount" v-slot="slotProps">
                            <el-input :placeholder="slotProps.placeholder" v-model="form.amount" class="w-full" size="large">
                                <template #prepend>{{ $page.props.currenry?.global }}</template>
                            </el-input>
                        </FieldGroup>
                        
                        <FieldGroup :inline="true" id="merchant" :placeholder="$t('Merchant')" :input-error="form.errors.merchant" v-slot="slotProps">
                            <el-select
                                v-model="form.merchant"
                                class="m-2"
                                placeholder="Select merchant"
                                size="large"
                            >
                                <el-option v-for="merchant in merchants" :key="merchant.id" :value="merchant.id" :label="merchant.name">
                                    <div class="flex items-center justify-between">
                                        <span>{{ merchant.name }}</span>
                                        <div class="w-5 h-5">
                                            <Icon :icon="merchant.icon" style="color: #fffc3d;" class="w-5 h-5" />
                                        </div>
                                    </div>

                                </el-option>
                            </el-select>
                        </FieldGroup>

                        <FieldGroup :inline="true" id="date" :placeholder="$t('Date')" :input-error="form.errors.date" v-slot="slotProps">
                            <el-date-picker
                                v-model="form.date"
                                type="date"
                                placeholder="Pick a day"
                                size="large"
                                format="YYYY-MM-DD"
                                value-format="YYYY-MM-DD"
                            />
                        </FieldGroup>

                    </div>

                    <div class="space-x-1">
                        <el-switch
                            v-model="form.confirm"
                            active-value="yes"
                            inactive-value="no"
                            class="ml-2"
                            style="--el-switch-on-color: #13ce66; --el-switch-off-color: #ff4949"
                        />
                        <span>{{ $t('Confirm') }}</span>
                    </div>
                    <div class="border border-red-300 bg-red-100 text-red-500 text-xs py-2 rounded text-center" v-if="form.errors.confirm">{{ form.errors.confirm }}</div>
                </div>
            </div>
        </template>

        <template #footer>
            <div class="flex space-x-2">
                <LinkButton v-if="form.status != 'pending'" class="px-4 py-2 space-x-2" :processing="form.processing" type="button" @click="submit">
                    <span>{{ $t('Save') }}</span>
                </LinkButton>

                <LinkButton class="px-4 py-2" theme="secondary" type="button" @click="modalOnClose">
                    {{ $t('Close') }}
                </LinkButton>
            </div>
        </template>
    </DialogModal>
</template>

<script setup>
    import { useForm, usePage } from '@inertiajs/vue3';
    import LinkButton from '@/Components/LinkButton.vue';
    import DialogModal from '@/Components/DialogModal.vue';
    import FieldGroup from '@/Components/FieldGroup.vue';
    import { trans } from 'laravel-vue-i18n';
    import { ref, watch } from 'vue';
    import { ElMessage } from 'element-plus'
    import RequestsIcon from '@/Components/Icons/wallet-withdraw.svg';
    import { Icon } from '@iconify/vue';

    const emit = defineEmits(["onModalClose"])

    const props = defineProps({
        modalTitle: {
            type: String,
            default: trans('')
        },
        showModal: {
            type: Boolean,
            default: false
        },
        customer: Object,
        merchants: Array,
        card: Object,
    })

    const form = useForm({
        _method: "POST",
        amount: 0,
        date: null,
        merchant: null,
        confirm: 'no',
    });

    const processing = ref(false)

    const modalOnClose = () => {
        processing.value = false
        
        form.reset()
        emit('onModalClose')
    }

    const submit = () => {
        form._method = 'POST'

        form.post(route('customers.cards.withdraw', {customer: props.customer, card: props.card}), {
            preserveState: true,
            onSuccess: () => {
                ElMessage.success(usePage().props?.flash?.success)

                modalOnClose()
            },
            onError: () => {},
        })

    }

</script>