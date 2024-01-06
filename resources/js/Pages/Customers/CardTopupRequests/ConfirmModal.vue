<template>   
    <DialogModal :show="showModal" maxWidth="lg" @close="modalOnClose">

        <template #content>

            <div v-if="mode == 'show'" class="space-y-4 flex flex-col items-center">
                <h4 class="text-center font-semibold uppercase">{{ $t('Topup Request Details') }}</h4>

                <div class="w-24 h-24 flex justify-center items-center">
                    <img :src="RequestsIcon" class="h-16 w-16" />
                </div>

                <div class="grid gap-4 w-full" :class="{'grid-cols-2': cardRequest.attachments.length > 1}" v-if="cardRequest">
                    <a  target="_blank" :href="attachment.file" v-for="(attachment, index) of cardRequest.attachments" :key="index" class="overflow-hidden border h-32 flex flex-col justify-center items-center group p-4 space-y-3">
                        <Icon :icon="getIcon(attachment.name)" class="w-12 h-12 scale-100 group-hover:scale-110 transition-all duration-300" />
                        <h5 class="truncate px-2 font-bold">{{ attachment.name }}</h5>
                    </a>
                </div>
            </div>

            <div v-else class="space-y-4 flex flex-col items-center">
                <h4 class="text-center font-semibold uppercase">{{ $t('Card Request') }}</h4>

                <div class="w-24 h-24 flex justify-center items-center">
                    <img :src="RequestsIcon" class="h-16 w-16" />
                </div>              

                <div class="mb-2 flex items-center text-sm">
                    <el-radio-group v-model="form.status">
                        <el-radio disabled label="pending" size="default">{{ $t('Pending') }}</el-radio>
                        <el-radio label="validated" size="default">{{ $t('Validated') }}</el-radio>
                        <el-radio label="cancelled" size="default">{{ $t('Cancelled') }}</el-radio>
                    </el-radio-group>
                </div>

                <div v-if="form.status != 'pending'" class="space-y-4">
                    <div v-if="form.status == 'validated'" class="space-y-4 rounded border p-6">
                        <FieldGroup :inline="false" id="amount" :placeholder="$t('Amount')" :input-error="form.errors.amount" v-slot="slotProps">
                            <el-input :placeholder="slotProps.placeholder" v-model="form.amount" class="w-full" size="large">
                                <template #prepend>USD</template>
                            </el-input>
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
    import RequestsIcon from '@/Components/Icons/wallet-add.svg';
    import { Icon } from '@iconify/vue';

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
        mode: String,
        cardRequest: Object,
    })

    const form = useForm({
        _method: "POST",
        status: 'pending',
        
        amount: 0,

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

        form.put(route('customers.topup-requests.update', {customer: props.customer, card_request: props.cardRequest}), {
            preserveState: true,
            onSuccess: () => {
                ElMessage.success(usePage().props?.flash?.success)

                modalOnClose()
            },
            onError: () => {},
        })

    }

    const getIcon = (file) => {
        
        const ext = file.split('.').pop()

        if (['pdf', 'PDF'].includes(ext)) {

            return 'bi:file-earmark-pdf'

        } else if (['jpeg', 'jpg', 'JPEG', 'JPG', 'png', 'PNG'].includes(ext)) {

            return 'bi:file-earmark-image'
            
        }

        return 'pepicons-print:file'

    }

</script>