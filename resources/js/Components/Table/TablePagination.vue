<script setup>

import { computed, ref } from "vue";
import Pagination from "../Pagination.vue"

const props =defineProps({
    meta : Object,
    perPage: {
        type: Number,
        default: 10
    },
    size: {
        type: String,
        default: "default"
    },
});

const per_page = ref(props.perPage);

const perPages = ref([ 5, 10, 25, 50, 75, 100, 150, 200 ])

defineEmits(['update']);

</script>

<template>
    <div class="flex justify-between px-5 py-3">
        <div class="flex flex-col items-start justify-start">
            <div class="w-24">
                <el-select
                    :auto-size="true"
                    :size="size"
                    class="w-full"
                    v-model="per_page"
                    @change="$emit('update', per_page)"
                    :placeholder="$t('Per Page')">

                    <el-option
                        v-for="item in perPages"
                        :key="item"
                        :filterable="true"
                        :label="item"
                        :value="item"
                    />
                </el-select>
            </div>
            <span class="text-xs font-light mt-1">{{ $t("Elements par page") }}</span>
        </div>

        <Pagination :links="meta.links" />

    </div>
</template>
