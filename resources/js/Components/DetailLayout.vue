<template>
    <div class="">
        <div class="relative overflow-hidden min-h-[8rem] bg-gray-700 text-center">
            <!-- SVG Background Element -->
            <figure class="absolute inset-x-0 bottom-0 -mb-px">
                <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                    viewBox="0 0 1920 100.1">
                    <path fill="currentColor" class="fill-white"
                        d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z"></path>
                </svg>
            </figure>
            <!-- End SVG Background Element -->
        </div>

        <div class="relative z-10 -mt-12">
            <!-- Icon -->
            <span class="mx-auto flex justify-center items-center w-[62px] h-[62px] rounded-full border border-gray-700 bg-white text-gray-700 shadow-sm">
                <Icon :icon="icon" class="w-8 h-8 text-gray-700" />
            </span>
            <!-- End Icon -->
        </div>

        <!-- Body -->
        <div class="p-4 sm:p-7 overflow-y-auto">
            <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-800">{{ title }}</h3>
                <p class="text-sm text-gray-500">{{ subTitle }}</p>
            </div>

            <slot />    


        </div>
        <!-- End Body -->
    </div>
</template>


<script setup>
    import { Icon } from '@iconify/vue';

    const props = defineProps({
        title: String,
        subTitle: String,
        icon: {
            default: 'tabler:file-invoice',
            type: String
        },
    })

</script>