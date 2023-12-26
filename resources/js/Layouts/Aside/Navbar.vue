<template>
    <TransitionRoot as="template" :show="sidebarOpen">
      <Dialog as="div" class="relative z-40 lg:hidden" @close="$emit('close')">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-600 bg-opacity-75" />
        </TransitionChild>

        <div class="fixed inset-0 z-40 flex">
          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
            <DialogPanel class="relative flex w-full max-w-xs flex-1 flex-col bg-gray-800 pb-4 pt-5">
              <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                <div class="absolute right-0 top-0 -mr-12 pt-2">
                  <button type="button" class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="$emit('close')">
                    <span class="sr-only">Close sidebar</span>
                    <Icon icon="material-symbols:close" class="h-6 w-6 text-white" aria-hidden="true" />
                    <!-- <XMarkIcon /> -->
                  </button>
                </div>
              </TransitionChild>
              <div class="flex flex-shrink-0 items-center px-4">
                <Link href="/" class="text-white">
                  VICARD ADMIN
                  <!-- <img class="h-12" :src="$page.props.app.brand.logo" :alt="$page.props.app.name" /> -->
                </Link>
              </div>
              <nav class="mt-5 h-full flex-shrink-0 divide-y divide-navbar-800 overflow-y-auto" aria-label="Sidebar">
                <div class="space-y-1 px-2">
                  <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-navbar-800 text-white' : 'text-cyan-100 hover:bg-cyan-600 hover:text-white', 'group flex items-center rounded-md px-2 py-2 text-base font-medium']" :aria-current="item.current ? 'page' : undefined">
                    <component :is="item.icon" class="mr-4 h-6 w-6 flex-shrink-0 text-cyan-200" aria-hidden="true" />
                    {{ item.name }}
                  </a>
                </div>
                <div class="mt-6 pt-6">
                  <div class="space-y-1 px-2">
                    
                    <template v-for="(block, index) in navbarLinks" :key="index">
                        <p class="font-light text-slate-400 text-xs uppercase pt-2">{{ block.block }}</p>
                        
                        <template v-for="(menu, menuIndex) in block.items" :key="menuIndex">

                          <NavbarMenuItem :menu="menu" />

                        </template>
                    </template>
             
                  </div>
                </div>
              </nav>
            </DialogPanel>
          </TransitionChild>
          <div class="w-14 flex-shrink-0" aria-hidden="true">
            <!-- Dummy element to force sidebar to shrink to fit close icon -->
          </div>
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-[265px] lg:flex-col z-50">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex flex-grow flex-col overflow-y-auto bg-gray-800 pb-4 pt-5">
        <div class="flex flex-shrink-0 items-center px-8 mb-2">
          
          <Link href="/" class="text-white w-full">
              VICARD ADMIN
              <!-- <img :class="$page.props.app.brand.is_default ? 'w-[70%]' : 'h-20 w-full'" :src="$page.props.app.brand.logo" :alt="$page.props.app.name" /> -->
            </Link>
        </div>
        <nav class="mt-5 flex flex-1 flex-col divide-y divide-navbar-800 overflow-y-auto scrollbar-thumb-gray-800 scrollbar-track-gray-600 scrollbar-thin" aria-label="Sidebar">
          <div class="space-y-1 px-6 text-white">
            <!-- <div class="bg-white py-2 px-4 leading-3 mb-3 text-gray-700 flex items-center rounded space-x-3">
                <div class="w-12 h-12 flex justify-center items-center border rounded-full">
                  <CircleStackIcon class="h-6 w-6 flex-shrink-0 text-gray-500" />
                </div>
                <div class="flex flex-col list-none">
                  <h3 class="text-lg font-bold">0 Dhs</h3>
                  <p class="text-gray-500 font-light text-sm">Avalable credits</p>
                </div>
            </div> -->
            <template v-for="(block, index) in navbarLinks" :key="index">
                <p class="font-light text-slate-400 text-xs uppercase pt-2">{{ block.block }}</p>
                
                <template v-for="(menu, menuIndex) in block.items" :key="menuIndex">

                  <NavbarMenuItem :menu="menu" />

                </template>
            </template>
        
          </div>
        </nav>
      </div>
    </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import NavbarMenuItem from './MenuItem.vue';
import { Icon } from '@iconify/vue';

defineProps({
    sidebarOpen: Boolean,
});

const navbarLinks = computed(() => {
    return usePage().props.menus.navbarLinks
});

const emit = defineEmits(['close']);
</script>