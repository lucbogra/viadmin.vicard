<template>   
    <DialogModal :show="showModal" maxWidth="lg" @close="modalOnClose" :padding="false">

        <template #content>
            <DetailLayout title="Card Request" sub-title="Details" icon="mdi:list-status">
                <!-- <pre>{{ cardRequest }}</pre> -->
                <div class="mt-6 space-y-3 divide-y">
                    <Description
                            :title="$t('User')"
                            :value="cardRequest.user?.name"
                            icon="ph:user"

                        />
                    <Description
                            class="pt-3"
                            :title="$t('Status')"
                            :value="cardRequest.status.label"
                            icon="mdi:list-status"

                        />
                    <Description
                            class="pt-3"
                            :title="$t('Date')"
                            :value="cardRequest.created_at?.formatted"
                            icon="uiw:date"

                        />
                </div>
            </DetailLayout>
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
    import LinkButton from '@/Components/LinkButton.vue';
    import DialogModal from '@/Components/DialogModal.vue';
    import Description from '@/Components/Description.vue';
    import { Icon } from '@iconify/vue';
    import DetailLayout from '@/Components/DetailLayout.vue';
    import { trans } from 'laravel-vue-i18n';

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
        cardRequest: Object,
    })

    const modalOnClose = () => {
        emit('onModalClose')
    }

</script>