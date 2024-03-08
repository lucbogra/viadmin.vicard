<script setup>
import Breadcrumb from '@/Components/Breadcrumb.vue';
import { Link } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
import Avatar from '@/Components/Avatar.vue';
import NavLink from '@/Components/NavLink.vue';
import BankCard2 from '@/Components/BankCard2.vue';

const props = defineProps({
    customer: Object,
    card: Object,
    breadcrumbs: Array,
});

</script>

<template>
    <div>

        <div class="px-10 py-5 border-t border-r border-l bg-white">
            <div class="block sm:flex items-center justify-between">
                <div class="w-full mb-1">
                    <div class="mb-5">
                        <Breadcrumb :section-left="false" :breadcrumbs="breadcrumbs" />
                    </div>
                    <div class="sm:flex space-x-4 items-center">
                        <BankCard2 class="w-92" v-if="card" :card="card" :link="false" small />
                        <div class="flex-1 flex space-x-4">
                            <Avatar :image="customer.avatar" size="24" icon="bx:user" />    

                            <div class="flex flex-1 space-x-2 sm:space-x-3 justify-between items-center">
                                <div class="space-y-0">
                                    
                                    <div class="text-gray-600 text-sm">
                                        <div>
                                            <p class="m-0 p-O flex items-center space-x-1 font-bold">
                                                <Icon icon="bx:user" />
                                                <span>{{ customer.name }}</span>
                                            </p>
                                            <p class="m-0 p-O flex items-center space-x-1">
                                                <Icon icon="mdi:at" />
                                                <span>{{ customer.email }}</span>
                                            </p>
                                            <p class="m-0 p-O flex items-center space-x-1">
                                                <Icon icon="ic:round-work-outline" />
                                                <span>{{ customer.role?.name }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- <div class="m-0 p-O uppercase text-xl font-bold flex space-x-2">

                                        dd f

                                    </div> -->
                                </div>
                                <div class="grid grid-cols-1 space-x-2">

                                
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                    
                </div>
            </div>

            <div class="mt-6 flex justify-between space-x-4">

                <div v-if="!card">
                    <div class="flex space-x-2">
                        <NavLink class="space-x-1" :href="route('customers.cards.index', {customer: customer})"
                                :active="route().current('customers.cards.index') || route().current('customers.show')">
                            <Icon icon="ion:card-outline" class="h-4 w-4" />
                            <span>Cards</span>
                        </NavLink>
    
                        <NavLink class="space-x-1" :href="route('customers.card-requests.index', {customer: customer})"
                                :active="route().current('customers.card-requests.index')">
                            <Icon icon="ic:round-add-card" class="h-4 w-4" />
                            <span>Card Requests</span>
                            <span style="font-size: .7em;;" class="w-4 h-4 rounded-full bg-orange-400 text-white inline-flex justify-center items-center" v-if="customer?.notifs?.card_requests_count">
                            {{ customer.notifs.card_requests_count }}
                            </span>
                        </NavLink>
    
                        <NavLink class="space-x-1" :href="route('customers.topup-requests.index', {customer: customer})"
                                :active="route().current('customers.topup-requests.index')">
                            <Icon icon="majesticons:money-plus-line" class="h-4 w-4" />
                            <span>Top Up Requests</span>
                            <span style="font-size: .7em;;" class="w-4 h-4 rounded-full bg-orange-400 text-white inline-flex justify-center items-center" v-if="customer?.notifs?.card_topup_requests_count">
                            {{ customer.notifs.card_topup_requests_count }}
                            </span>
                        </NavLink>

                        <NavLink class="space-x-1" :href="route('customers.invoices.index', {customer: customer})"
                                :active="route().current('customers.invoices.index')">
                            <Icon icon="uil:invoice" class="h-4 w-4" />
                            <span>Invoices</span>
                            <span style="font-size: .7em;;" class="w-4 h-4 rounded-full bg-orange-400 text-white inline-flex justify-center items-center" v-if="customer?.notifs?.invoices_count">
                            {{ customer.notifs.invoices_count }}
                            </span>
                        </NavLink>
                        
                    </div>
                </div>
                <div v-else>
                    <div class="flex space-x-2">
                        <NavLink class="space-x-1" :href="route('customers.show', {customer: customer})">
                            <Icon icon="bx:arrow-back" class="h-4 w-4" />
                            <span>Back to customer profile</span>
                        </NavLink>

                        <NavLink class="space-x-1" :href="route('customers.cards.edit', {customer: customer, card: card})"
                                :active="route().current('customers.cards.edit')">
                            <Icon icon="mdi:credit-card-edit-outline" class="h-4 w-4" />
                            <span>Edit Card</span>
                        </NavLink>

                        <NavLink class="space-x-1" :href="route('customers.cards.transactions', {customer: customer, card: card})"
                                :active="route().current('customers.cards.transactions')">
                            <Icon icon="grommet-icons:transaction" class="h-4 w-4" />
                            <span>Card transactions</span>
                        </NavLink>

                        <NavLink class="space-x-1" :href="route('customers.cards.show', {customer: customer, card: card})"
                                :active="route().current('customers.cards.show')">
                            <Icon icon="ion:card-outline" class="h-4 w-4" />
                            <span>Card details</span>
                        </NavLink>

                        <NavLink class="space-x-1" :href="route('customers.cards.members', {customer: customer, card: card})"
                                :active="route().current('customers.cards.members')">
                            <Icon icon="ph:users-three-bold" class="h-4 w-4" />
                            <span>Members</span>
                        </NavLink>
                    </div>
                </div>

                <!-- <Link v-if="!card" :href="route('customers.edit', {customer: customer})" class="inline-flex items-center px-4 py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1">Editer</span>
                </Link> -->
                
            </div>
            
        </div>

    </div>
</template>