<script setup>
import { ref } from 'vue';
import Pagination from './TablePagination.vue';
import ProcessingLoader from '../ProcessingLoader.vue';

const props = defineProps({
    items: Object,
    additionalClasses: String,
    perPage: Number,
    showPagination: {
        type: Boolean,
        default: true
    },
    rounded: {
        type: Boolean,
        default: true
    },
    bordered: {
        type: Boolean,
        default: true
    },
    loading: {
        type: Boolean,
        default: false
    }
});

const per_page = ref(props.perPage);

const emit = defineEmits(['updatePerPage']);

const updatePerPage = (newValue) => {
    emit("updatePerPage", newValue)
}

</script>

<template>
    <div class="w-full">
        <slot name="search" />

        <div v-if="items?.data?.length > 0" class="overflow-auto w-full">

            <div class="w-full rounded overflow-auto" :class="{'rounded': rounded, 'border border-gray-800': bordered, 'relative': loading}">
                <div v-if="loading" class="absolute inset-0 w-full h-full bg-gray-200 opacity-50">
                    <div class="w-full h-full flex justify-center items-center">
                        <ProcessingLoader class="w-20" />
                    </div>
                </div>

                <table class="w-full table-auto">
                    <slot name="thead" />
                    <slot cl v-bind="{items: items.data}" />
                </table>

                <Pagination :per-page="per_page"
                            v-if="showPagination"
                            :meta="items.meta"
                            @update="updatePerPage"
                        />
            </div>
        </div>

        <div v-else :class="{'relative': loading}">
            <div v-if="loading" class="absolute inset-0 w-full h-full bg-gray-200 opacity-50">
                <div class="w-full h-full flex justify-center items-center">
                    <ProcessingLoader class="w-20" />
                </div>
            </div>
            <slot name="empty" />
        </div>

    </div>
</template>
