<template>   
    <DialogModal :show="showModal" maxWidth="2xl" @close="modalOnClose">

        <template #content>

            <div class="p-6">
                <InvoiceTemplate :invoice="invoice" />
            </div>

        </template>

        <template #footer>
            <div class="flex space-x-2">

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
    import InvoiceTemplate from '@/Components/InvoiceTemplate.vue';

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
        invoice: Object,
    })

    const form = useForm({
        _method: "POST",
    });

    const processing = ref(false)

    const modalOnClose = () => {
        processing.value = false
        form.reset()
        emit('onModalClose')
    }

</script>