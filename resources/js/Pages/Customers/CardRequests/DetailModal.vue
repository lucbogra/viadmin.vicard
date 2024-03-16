<template>   
    <DialogModal :show="showModal" maxWidth="lg" @close="modalOnClose" :padding="false">

        <template #content>
            <div>

                <DetailLayout title="Card Request" sub-title="Details" icon="mdi:list-status">
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

                <div class="space-y-4 flex flex-col items-center mx-6 mb-4">
                    <h4 class="text-center font-semibold uppercase">{{ $t('Receips') }}</h4>

                    <div class="grid gap-4 w-full" :class="{'grid-cols-2': cardRequest.receips.length > 1}" v-if="cardRequest.receips">
                        <a  target="_blank" :href="receip.file" v-for="(receip, index) of cardRequest.receips" :key="index" class="overflow-hidden border h-32 flex flex-col justify-center items-center group p-4 space-y-3">
                            <Icon :icon="getIcon(receip.name)" class="w-12 h-12 scale-100 group-hover:scale-110 transition-all duration-300" />
                            <h5 class="truncate px-2 font-bold">{{ receip.name }}</h5>
                        </a>
                    </div>
                    <div v-else class="w-full">
                        <div class="text-center py-2 border rounded border-orange-300 text-orange-400 bg-orange-100 w-full">
                            {{ $t('No Receips') }}
                        </div>
                    </div>
                </div>
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
    import LinkButton from '@/Components/LinkButton.vue';
    import DialogModal from '@/Components/DialogModal.vue';
    import Description from '@/Components/Description.vue';
    import { Icon } from '@iconify/vue';
    import DetailLayout from '@/Components/DetailLayout.vue';
    import { trans } from 'laravel-vue-i18n';
    import { getIcon } from '@/Components/helper.js';

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