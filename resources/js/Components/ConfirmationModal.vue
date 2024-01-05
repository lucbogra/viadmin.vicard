<script setup>
import Modal from './Modal.vue';
import { Icon } from '@iconify/vue';

const emit = defineEmits(['close']);

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const close = () => {
    emit('close');
};
</script>

<template>
    <Modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

            <div class="mt-3 text-center sm:mt-0 sm:ms-4 sm:text-start flex flex-col items-center space-y-2">
                <div class="mx-auto shrink-0 flex items-center justify-center h-20 w-20 rounded-full bg-red-100">
                    <Icon icon="octicon:alert-24" class="h-10 w-10 text-red-600" />
                </div>
                <h3 class="text-lg font-medium text-gray-900 uppercase">
                    <slot name="title" />
                </h3>

                <div class="mt-4 text-sm text-gray-600">
                    <slot name="content" />
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-end">
            <slot name="footer" />
        </div>
    </Modal>
</template>
