<template>
    <Head :title="title" />
  
    <div class="min-h-full">
      
      <Navbar :sidebar-open="sidebarOpen" @close="sidebarOpen = false" />
  
      <div class="flex flex-1 flex-col pl-64">

        <div class="flex h-16 flex-shrink-0 border-b border-gray-200 bg-white app-header">
            <button type="button" class="border-r border-gray-200 px-4 text-gray-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-cyan-500 lg:hidden"
                    @click="sidebarOpen = true">
                <span class="sr-only">Open sidebar</span>
                <Icon icon="fe:bar" class="h-6 w-6" />
            </button>
  
            <div class="flex flex-1 justify-between px-4 sm:px-6 lg:mx-auto lg:max-w-6xl lg:px-8">
                    <div class="flex flex-1 rtl:ml-4">
                        <form class="flex w-full md:ml-0" action="#" method="GET">
                            <label for="search-field" class="sr-only">Search</label>
                            <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center" aria-hidden="true">
                                    <Icon icon="fe:search" class="h-5 w-5" />
                                </div>
                                <input id="search-field" name="search-field" class="block h-full w-full border-transparent py-2 pl-8 pr-3 text-gray-900 focus:border-transparent focus:outline-none focus:ring-0 sm:text-sm" :placeholder="$t('Search')" type="search" />
                            </div>
                        </form>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button type="button" class="flex items-center rtl:ml-2 justify-center w-10 h-10 border text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                            <span class="sr-only">View notifications</span>
                            <Icon icon="ph:bell" class="h-6 w-6" />
                        </button>
                    
                        <!-- <div class="rtl:ml-2">
                            <Dropdown width="48">
                                <template #trigger>
                                    <button type="button" class="flex items-center justify-center w-10 h-10 border text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        <div class="w-5 h-5"><img :src="'/assets/flags/' + $page.props.app.locale.current.flag + '.png'"></div>
                                    </button>
                                </template>
        
                                <template #content>
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ $t("Choose Language") }}
                                    </div>
        
                                    <template v-for="(lang, index) of $page.props.app.langs" :key="index">
                                        <div class="border-t border-gray-200" />
                                        <form @submit.prevent="setLang(index)">
                                            <DropdownLink as="button">
                                                <div class="flex justify-between items-center">
                                                <span>{{ lang.label }}</span>
                                                <div class="w-6 h-6"><img :src="`/assets/flags/${lang.flag}.png`" :alt="lang.label"></div>
                                                </div>
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </template>
                            </Dropdown>
                        </div> -->
    
                        <div>
                            <Dropdown width="48">
                                <template #trigger>
                                    <button type="button" class="flex items-center space-x-2 px-3 h-10 border text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        <!-- <img class="h-5 w-5 rounded-full mr-2" alt="" /> -->
                                        <Avatar :src="$page.props.auth.user.avatar" icon="ph:user-bold" />
                                        <div class="flex flex-col items-start">
                                            <span class="">{{ $page.props.auth.user.name }}</span>
                                            <span class="font-light" style="font-size: .8em">Admin</span>
                                        </div>
                                        <Icon icon="octicon:chevron-down-16" class="ml-2 hidden h-4 w-4 flex-shrink-0 text-gray-400 lg:block" />
                                    </button>
                                </template>
        
                                <template #content>
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ $t("Menu") }}
                                    </div>
                                    <DropdownLink :href="route('profile.show')" :active="route().current('profile.show')">
                                        {{ $t("Profile") }}
                                    </DropdownLink>
                                    <DropdownLink :href="route('profile.show')" :active="route().current('profile.show')">
                                        {{ $t("Settings") }}
                                    </DropdownLink>
                                    <div class="border-t border-gray-200" />
                                    <DropdownLink class="inline-block" as="button" @click="showConfirmModal = true">
                                        {{ $t("Log out") }}
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </div>
        
            <main class="flex-1 app-main">

                <div class="px-10 py-2">
                    <slot name="header" />
                </div>
        
                <div class="px-10 py-2 app-breadcrumbs">
                    <Breadcrumb :breadcrumbs="breadcrumbs" />
                </div>
                
                <div class="w-full">
                    <FlashMessage />
                    <slot />
                </div>
            </main>
        </div>
  
        <ConfirmationModal max-width="sm" :show="showConfirmModal" @close="showConfirmModal = false">
            <template #title>
                {{ $t("Confirmation") }}
            </template>
    
            <template #content>
                {{ $t("Are you sure you would like to logout ?") }}
            </template>
  
            <template #footer>
                <div class="flex space-x-2">
                    <CustomButton class="px-4 py-2 space-x-2" theme="danger" :processing="loggingOut" type="button" @click="logout">
                        <span>{{ $t("Log out") }}</span>
                    </CustomButton>
                    
                    <CustomButton class="px-4 py-2" theme="secondary" type="button" @click="showConfirmModal = false">
                        {{ $t('Close') }}
                    </CustomButton>
                </div>
            </template>
        </ConfirmationModal>
  
    </div>
    
  </template>
  
  
  <script setup>
  import { ref } from 'vue';
  import { Link, router, Head } from '@inertiajs/vue3';
  import Navbar from './Aside/Navbar.vue';
  import Dropdown from '@/Components/Dropdown.vue';
  import DropdownLink from '@/Components/DropdownLink.vue';
  import ConfirmationModal from '@/Components/ConfirmationModal.vue';
  import CustomButton from '@/Components/CustomButton.vue';
  import Breadcrumb from '@/Components/Breadcrumb.vue';
  import FlashMessage from '@/Components/FlashMessage.vue';
  import Avatar from '@/Components/Avatar.vue';
  import { Icon } from '@iconify/vue';
  
  defineProps({
      title: String,
      breadcrumbs: {
        type: Array,
        default: []
      }
  });
  
  const sidebarOpen = ref(false)
  const showConfirmModal = ref(false)
  const loggingOut = ref(false)
  
  const logout = () => {
      loggingOut.value = true
  
      router.post(route('logout'), {
          preserveState: true,
          onSuccess: () => {
            loggingOut.value = false
              // ElMessage.success(usePage().props?.flash?.success)
          },
          onError: (onError) => {
            loggingOut.value = false
          },
          
      })
  };
  
  </script>
  