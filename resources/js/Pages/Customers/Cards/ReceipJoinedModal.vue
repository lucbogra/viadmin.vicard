<template>
    <DialogModal :show="showModal" maxWidth="2xl" @close="modalOnClose">

        <template #content>

            <div class="space-y-4 flex flex-col items-center pb-4">

                    <div>
                        <h4 class="text-center font-semibold uppercase mb-4">{{ $t('File added') }}</h4>
                        <div class="grid gap-4 w-full" :class="{'grid-cols-2': receips.length > 1}" v-if="item">
                            <a  target="_blank" :title="receip.name" :href="receip.file" v-for="(receip, index) of receips" :key="index" class="overflow-hidden border h-32 flex flex-col justify-center items-center group p-4 space-y-3">
                                <Icon :icon="getIcon(receip.name)" class="w-12 h-12 scale-100 group-hover:scale-110 transition-all duration-300" />
                                <h5 class="truncate px-2 font-bold">{{ receip.name }}</h5>
                            </a>
                        </div>

                        <div v-if="!receips.length" class="text-orange-300 w-full text-center">
                            {{ $t('There is any file') }}
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
    import { trans } from 'laravel-vue-i18n';
    import { ref, watch } from 'vue';
    import { Icon } from '@iconify/vue';

    const emit = defineEmits(["onModalClose"])

    const props = defineProps({
        modalTitle: {
            type: String,
            default: trans('Incoice')
        },
        showModal: {
            type: Boolean,
            default: false
        },
        item: Object,
        card: Object,
    })

    const modalOnClose = () => {
        emit('onModalClose')
    }

    const receips = ref([])

    watch(() => {
        receips.value = props.item?.receips ?? []
    })

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
