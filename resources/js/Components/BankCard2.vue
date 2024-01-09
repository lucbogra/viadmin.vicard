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
    });
</script>

<template>

    <Link v-if="link" :href="route('customers.cards.index', {customer: card.owner, card: card})"
            class="border w-full h-56 m-auto bg-red-100 rounded-xl relative text-white shadow-2xl transition-transform transform hover:scale-100">

        <img class="relative object-cover w-full h-full rounded-xl" src="/assets/card-bg-design.jpg">

        <div class="w-full px-6 py-6 absolute top-0 h-full">


            <div class="flex flex-col">
                <div class="flex justify-between pb-4">
                    <div class="flex flex-col items-end leading-none">
                        <h1 class="text-3xl font-semibold text-gray-100">VICARDS</h1>
                        <span style="font-size: .5em;">VIRTUAL CARDS</span>
                    </div>
                    <div>
                        <Icon icon="flat-color-icons:sim-card-chip" class="h-10 w-10" />
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4">

                    <div class="flex flex-col items-center w-full">
                        <span class="text-3xl text-gray-300 font-bold font-ocr">{{ card . card_number }}</span>
                        <div class="flex items-center space-x-1">
                            <span style="font-size: .4em;" class="w-6">VALID THRU</span>
                            <span class="text-sm text-gray-300 font-bold">{{ card . card_validity . month }}</span>
                        </div>
                    </div>


                </div>

                <div class="flex justify-between items-end">
                    <span style="font-size: .5em;" class="uppercase mb-2">Valid only for advertising</span>
                    <div>
                        <Icon icon="simple-icons:visa" class="h-14 w-14" />
                    </div>
                </div>
            </div>


        </div>
    </Link>
</template>
