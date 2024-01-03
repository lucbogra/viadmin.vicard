<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import LinkButton from '@/Components/LinkButton.vue';
import FieldGroup from "@/Components/FieldGroup.vue";
import UserSearchIcon1 from '@/Components/Icons/user-search-1.svg';
import UserSearchIcon2 from '@/Components/Icons/user-search-2.svg';
import { useForm } from "@inertiajs/vue3";
import { Icon } from '@iconify/vue';
import { onMounted, ref, watch } from 'vue';
import { ElMessage } from 'element-plus';

const props = defineProps({
    breadcrumbs: Array,
});

const form = useForm({
    _method: "POST",
    name: null,
    email: null,
    password: null,
    type: [],
    password_copied: 'no',
    cod_investor_id: null,
});

const copyInput = ref(null)
const copyInput2 = ref(null)
const affiliate = ref(null)
const passwordCopied = ref(null)
const affiliateLists = ref([])

const handleSelect = (item) => {
    form.cod_investor_id = item.id
    form.name = item.name
    form.email = item.email
    form.type = item.type
    form.password = generateRandomString(10)
}

const handleChange = (item) => {
    alert(affiliate.value)
}

onMounted(() => {
    loadAffiliates()
})

const loadAffiliates = async (queryString) => {
    let lists = []

    let url = 'http://codinvestor.test/api/users/investors/all'

    if (queryString) {
        url += '?search=' + queryString
    }

    await axios.get(url).then((data) => {
        lists = data.data
        affiliateLists.value = data.data
    });

    return lists
}


const generatePassword = () => {
    form.password = generateRandomString(10)
}

const generateRandomString = (length = 10) => {
    const charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@-_^*";
    let randomString = "";

    for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * charset.length);
        randomString += charset.charAt(randomIndex);
    }

    return randomString;
}

const copyPassword = () => {
    copyInput.value.focus()
    copyInput.value.select();
    copyInput.value.setSelectionRange(0, 9999999);

    copyInput2.value.focus()
    copyInput2.value.select();

    document.execCommand('copy');

    passwordCopied.value = form.password

    form.password_copied = 'yes'

    ElMessage.success("Password Copied")
}

watch(form, () => {
    form.password_copied = 'no'

    if (form.password != null) {

        if (form.password == passwordCopied.value) {
            form.password_copied = 'yes'
        }
    }
})

const submit = () => {
    let url = route('customers.store')

    form._method = 'POST'

    form.post(url, {
        preserveState: true,
        onSuccess: () => {
            ElMessage.success(usePage().props?.flash?.success)
        },
        onError: () => {},
    })

}

</script>

<template>
    <AppLayout :title="$t('New Customer')"> 
            
        <div class="">
            <form @submit.prevent="submit" class="bg-white mx-10 px-10 block" :class="form.cod_investor_id ? 'mb-8 pb-8' : ''">
                <div class="space-y-6">
                
                    <div class="flex flex-col items-center space-y-3 justify-center transition-all duration-300" :class="form.cod_investor_id ? 'py-8' : 'py-32'">
                        <div class="rounded-full inline-block border border-gray-400 flex justify-center items-center transition-all duration-300"
                            :class="form.cod_investor_id ? 'h-16 w-16' : 'h-32 w-32'">
                            <!-- <Icon icon="lucide:user-search" class="h-20 w-20 text-gray-400" /> -->
                            <img :src="UserSearchIcon1" class="transition-all duration-300" :class="form.cod_investor_id ? 'h-8 w-8' : 'h-20 w-20'" />
                            
                        </div>
                        <h4 class="text-center font-semibold text-xl text-gray-500 uppercase mb-5">{{ $t('Search COD affiliate') }}</h4>
                        <el-autocomplete
                            v-model="affiliate"
                            :fetch-suggestions="loadAffiliates"
                            :placeholder="$t('Search Affiliate')"
                            :trigger-on-focus="false"
                            label="name"
                            value-key="name"
                            @select="handleSelect"
                            class="w-full" size="large"
                        >
                            <template #prefix>
                                <Icon icon="lucide:user-search" />
                            </template>
                            <template #default="{ item }">
                                <div class="flex flex-col py-2">
                                    <span class="text-gray-700 font-bold">{{ item.name }}</span>
                                    <span class="text-gray-400 text-xs">{{ item.email }}</span>
                                </div>
                            </template>
                        </el-autocomplete>
                    </div>

                    <div v-if="form.cod_investor_id != null" class="mt-6 space-y-4 rounded">

                        <h5 class="text-center text-gray-500 mb-10 border rounded py-3 bg-gray-50">{{ $t('The form has been pre-filled with the information of the selected affiliate') }}</h5>

                        <FieldGroup :inline="false" id="name" :placeholder="$t('Fullname')" :input-error="form.errors.name" v-slot="slotProps">
                            <el-input disabled :placeholder="slotProps.placeholder" v-model="form.name" class="w-full" size="large" />
                        </FieldGroup>

                        <FieldGroup :inline="false" id="email" :placeholder="$t('Email')" :input-error="form.errors.email" v-slot="slotProps">
                            <el-input disabled :placeholder="slotProps.placeholder" v-model="form.email" class="w-full" size="large" />
                        </FieldGroup>

                        <FieldGroup :inline="false" id="type" :placeholder="$t('Type')" :input-error="form.errors.type" v-slot="slotProps">
                            <el-tag v-for="(role, index) of form.type" :key="index" class="ml-2" type="success">{{ role }}</el-tag>
                        </FieldGroup>

                        <FieldGroup :inline="false" id="password" :placeholder="$t('Password')" :input-error="form.errors.password" v-slot="slotProps">
                            <input ref="copyInput" class="hidden" v-model="form.password" />
                            
                            <el-input ref="copyInput2" show-password :placeholder="slotProps.placeholder" v-model="form.password" class="w-full" size="large">
                                <template #append>
                                    <el-button @click="generatePassword"><Icon icon="prime:refresh" /></el-button>
                                </template>
                            </el-input>

                            <div v-if="form.password" class="mt-1">
                                <div class="flex items-center text-xs text-gray-500 space-x-2">
                                    <span>{{ $t('Copy the password before to submit') }}</span>
                                    <el-button circle @click="copyPassword" size="small" type="primary">
                                        <Icon icon="prime:copy" />
                                    </el-button>
                                    <span v-if="form.password == passwordCopied" class="text-green-500 text-xs">{{ $t('Password copied') }}</span>
                                </div>
                            </div>

                            <div class="mt-1" v-if="form.errors.password_copied && form.password_copied == 'no'">
                                <el-alert
                                    title="You most copy the password before to submit"
                                    type="warning"
                                    :closable="false"
                                    show-icon
                                />
                            </div>
                        </FieldGroup>

                        <div>
                            <LinkButton class="px-5 py-2 space-x-2 mt-5 mb-2 md:w-auto w-full flex justify-center" :outline="true" type="submit" :processing="form.processing">
                                <span>{{ staff?.id ? $t("Mettre à jours") : $t("Créer l'employé") }}</span>
                                <template #icon>
                                    <Icon icon="typcn:staff-add-outline" class="h-4 w-4" />
                                </template>
                            </LinkButton>
                        </div>
                    </div>
                    
                </div>  

            </form> 

        </div>
     
    </AppLayout>
</template>
