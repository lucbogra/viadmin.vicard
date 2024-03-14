<template>
    <DialogModal :show="showModal" maxWidth="2xl" @close="modalOnClose">

        <template #content>
            <div class="grid grid-cols-3 gap-6">
                <div class="space-y-4 flex flex-col items-center">
                    <h4 class="text-center font-semibold uppercase">{{ $t('Receips') }}</h4>

                    <div class="grid gap-4 w-full" :class="{'grid-cols-2': cardRequest.receips.length > 1}" v-if="cardRequest.receips?.length">
                        <a  target="_blank" :href="receip.file" v-for="(receip, index) of cardRequest.receips" :key="index" class="overflow-hidden border h-32 flex flex-col justify-center items-center group p-4 space-y-3">
                            <Icon :icon="getIcon(receip.name)" class="w-12 h-12 scale-100 group-hover:scale-110 transition-all duration-300" />
                            <h5 class="truncate px-2 font-bold">{{ receip.name }}</h5>
                        </a>
                    </div>
                    <p v-else class="text-center text-orange-500">No receips</p>
                </div>
                <div class="col-span-2 space-y-4 flex flex-col items-center">
                    <h4 class="text-center font-semibold uppercase">{{ $t('Card Request') }}</h4>

                    <div class="w-24 h-24 flex justify-center items-center">
                        <img :src="SendRequestIcon" class="h-16 w-16" />
                    </div>

                    <div class="mb-2 flex items-center justify-center text-sm border w-full">
                        <el-radio-group v-model="form.status">
                            <el-radio disabled label="pending" size="default">{{ $t('Pending') }}</el-radio>
                            <el-radio label="validated" size="default">{{ $t('Validated') }}</el-radio>
                            <el-radio label="cancelled" size="default">{{ $t('Cancelled') }}</el-radio>
                        </el-radio-group>
                    </div>

                    <div v-if="form.status != 'pending'" class="space-y-4">
                        <div v-if="form.status == 'validated'" class="space-y-4 rounded border p-6">
                            <FieldGroup :inline="false" id="nickname" :placeholder="$t('Nickname')" :input-error="form.errors.nickname" v-slot="slotProps">
                                <el-input :placeholder="slotProps.placeholder" v-model="form.nickname" class="w-full" size="large" />
                            </FieldGroup>

                            <FieldGroup :inline="false" id="card_number" :placeholder="$t('Card Number')" :input-error="form.errors.card_number" v-slot="slotProps">
                                <el-input :placeholder="slotProps.placeholder" v-model="form.card_number" class="w-full" size="large" />
                            </FieldGroup>

                            <FieldGroup :inline="false" id="card_validity" :placeholder="$t('Validity')" :input-error="form.errors.card_validity" v-slot="slotProps">
                                <div>
                                    <el-date-picker
                                        v-model="form.card_validity"
                                        type="date"
                                        placeholder="Select expired date"
                                        class="w-full" size="large"
                                        format="DD/MM/YYYY"
                                        value-format="YYYY-MM-DD"
                                    />
                                </div>
                            </FieldGroup>

                            <div class="grid grid-cols-1 gap-4">
                                <FieldGroup :inline="false" id="card_limit" :placeholder="$t('Card Limit')" :input-error="form.errors.card_limit" v-slot="slotProps">
                                    <el-input :placeholder="slotProps.placeholder" v-model="form.card_limit" class="w-full" size="large">
                                        <template #prepend>USD</template>
                                    </el-input>
                                </FieldGroup>

                                <FieldGroup :inline="false" id="daily_limit" :placeholder="$t('Daily Limit')" :input-error="form.errors.daily_limit" v-slot="slotProps">
                                    <el-input :placeholder="slotProps.placeholder" v-model="form.daily_limit" class="w-full" size="large">
                                        <template #prepend>USD</template>
                                    </el-input>
                                </FieldGroup>

                                <FieldGroup :inline="false" id="per_transaction_limit" :placeholder="$t('Limit Per Transaction')" :input-error="form.errors.per_transaction_limit" v-slot="slotProps">
                                    <el-input :placeholder="slotProps.placeholder" v-model="form.per_transaction_limit" class="w-full" size="large">
                                        <template #prepend>USD</template>
                                    </el-input>
                                </FieldGroup>
                            </div>

                            <FieldGroup :inline="false" id="card_type" :placeholder="$t('Card Type')" :input-error="form.errors.card_type" v-slot="slotProps">
                                <div>
                                    <el-radio-group v-model="form.card_type">
                                        <el-radio label="virtual" size="default">{{ $t('Virtual') }}</el-radio>
                                        <el-radio label="physical" size="default">{{ $t('Physical') }}</el-radio>
                                    </el-radio-group>
                                </div>
                            </FieldGroup>

                            <FieldGroup :inline="false" id="card_status" :placeholder="$t('Card Status')" :input-error="form.errors.card_status" v-slot="slotProps">
                                <div>
                                    <el-radio-group v-model="form.card_status">
                                        <el-radio label="activated" size="default">{{ $t('Activated') }}</el-radio>
                                        <el-radio label="not activated" size="default">{{ $t('Not Activated') }}</el-radio>
                                        <el-radio label="frozen" size="default">{{ $t('Frozen') }}</el-radio>
                                    </el-radio-group>
                                </div>
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
    import SendRequestIcon from '@/Components/Icons/send-request.svg';
    import { Icon } from '@iconify/vue';
    import { getIcon } from '@/Components/helper.js';

    const emit = defineEmits(["onModalClose"])

    const props = defineProps({
        modalTitle: {
            type: String,
            default: trans('Nouvelle fiche de paie')
        },
        showModal: {
            type: Boolean,
            default: false
        },
        customer: Object,
        cardRequest: Object,
    })

    const form = useForm({
        _method: "POST",
        status: 'pending',

        nickname: null,
        card_number: null,
        card_validity: null,
        card_limit: null,
        card_status: 'activated',
        card_type: 0,
        daily_limit: null,
        per_transaction_limit: null,
        card_fees: null,

        confirm: 'no',
    });

    const processing = ref(false)

    const modalOnClose = () => {
        processing.value = false
        form.reset()
        emit('onModalClose')
    }

    const submit = () => {
        form._method = 'PUT'

        form.put(route('customers.card-requests.update', {customer: props.customer, card_request: props.cardRequest}), {
            preserveState: true,
            onSuccess: () => {
                console.log(usePage().props?.flash);
                ElMessage.success(usePage().props?.flash?.success)

                modalOnClose()
            },
            onError: () => {},
        })

    }

</script>
