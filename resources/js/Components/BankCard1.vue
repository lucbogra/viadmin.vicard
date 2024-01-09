<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    card: Object,
    link: {
        default: true,
        type: Boolean
    },
    showBalance: {
        default: false,
        type: Boolean
    },
});

</script>

<template>
    
    <Link v-if="link" :href="route('cards.show', {card: card})" class="w-full p-6 bg-gradient-to-r from-primary-500 to-primary-700 rounded-lg">
        <div class="flex justify-between">
            <h1 class="text-3xl font-semibold text-gray-100 pb-4">VICARD</h1>
            <h1 v-if="showBalance" class="text-3xl font-semibold text-gray-100 pb-4">
                {{ card.card_balance }}
            </h1>
        </div>

        <span class="text-xs  text-gray-200 shadow-2xl">{{ card.owner?.name }}</span>


        <div class="flex justify-between items-center pt-4">

            <div class="flex flex-col">
                <span class="text-xl text-gray-300 font-bold font-ocr">{{ card.card_number }}</span>
                <span class="text-xs text-gray-300 font-bold">{{ card.card_validity.month }}</span>
            </div>

            <img src="https://img.icons8.com/offices/80/000000/sim-card-chip.png" width="48" />
            
        </div>
        
    </Link>
    <div v-else class="w-full p-6 bg-gradient-to-r from-primary-500 to-primary-700 rounded-lg">
        <div class="flex justify-between">
            <h1 class="text-3xl font-semibold text-gray-100 pb-4">VICARD</h1>
            <h1 v-if="showBalance" class="text-3xl font-semibold text-gray-100 pb-4">
                {{ card.card_balance }}
            </h1>
        </div>

        <span class="text-xs  text-gray-200 shadow-2xl">{{ card.owner?.name }}</span>


        <div class="flex justify-between items-center pt-4">

            <div class="flex flex-col">
                <span class="text-xl text-gray-300 font-bold font-ocr">{{ card.card_number }}</span>
                <span class="text-xs text-gray-300 font-bold">{{ card.card_validity.month }}</span>
            </div>

            <img src="https://img.icons8.com/offices/80/000000/sim-card-chip.png" width="48" />
            
        </div>
        
    </div>
</template>