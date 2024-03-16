<script setup>
    import {
        Link
    } from '@inertiajs/vue3';
    import {
        Icon
    } from '@iconify/vue';

    const props = defineProps({
        card: Object,
        link: {
            default: true,
            type: Boolean
        },
        small: Boolean
    });
</script>

<template>

    <Link :href="link ? route('customers.cards.show', {customer: card.owner, card: card}) : '#'" 
        class="border w-full m-auto bg-red-100 rounded-xl relative text-white transition-transform transform hover:scale-100"
        :class="small ? 'h-32 shadow-xl' : 'h-42 shadow-2xl'"
    >

        <img class="relative object-cover w-full h-full rounded-xl" src="/assets/card-bg-design.jpg">

        <div class="w-full absolute top-0 h-full" :class="small ? 'px-3 py-3' : 'px-6 py-6'">


            <div class="flex flex-col">
                <div class="flex justify-between" :class="{'': !small}">
                    <div class="flex flex-col items-end leading-none">
                        <h1 class="font-semibold text-gray-100" :class="small ? 'text-md' : 'text-xl'">VICARDS</h1>
                        <span :style="small ? 'font-size: .3em;' : 'font-size: .4em;'">VIRTUAL CARDS</span>
                    </div>
                    <div>
                        <Icon icon="flat-color-icons:sim-card-chip" :class="small ? 'h-8 w-8' : 'h-10 w-10'" />
                    </div>
                </div>

                <div class="flex justify-between items-center" :class="{'pt-1': !small}">

                    <div class="flex flex-col items-center w-full">
                        <span class="text-gray-300 font-bold font-ocr" :class="small ? 'text-md' : 'text-2xl'">{{ card . card_number }}</span>
                        <div class="flex items-center space-x-1">
                            <span style="font-size: .4em;" class="w-6">VALID THRU</span>
                            <span class="text-sm text-gray-300 font-bold">{{ card . card_validity . month }}</span>
                        </div>
                    </div>


                </div>

                <div class="flex justify-between items-end">
                    <div class="flex flex-col">
                        <h3 class="font-ocr">{{ card.nickname }}</h3>
                        <span style="font-size: .5em;" class="uppercase mb-2">Valid only for advertising</span>
                    </div>
                    <div>
                        <Icon icon="simple-icons:visa" class="h-14 w-14" />
                    </div>
                </div>
            </div>


        </div>
    </Link>
</template>
