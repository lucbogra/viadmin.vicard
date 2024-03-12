<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import LinkButton from '@/Components/LinkButton.vue';
    import ProfileHeader from '../ProfileHeader.vue';
    import ActionLinkButton from '@/Components/ActionLinkButton.vue';
        import FieldGroup from '@/Components/FieldGroup.vue';
    import debounce from 'lodash/debounce';
    import { Icon } from '@iconify/vue';
    import Avatar from '@/Components/Avatar.vue';
    import { useForm, usePage } from '@inertiajs/vue3';
    import { ref, watch } from 'vue';

    const props = defineProps({
        card: Object,
        customer: Object,
        filter: Object,
        breadcrumbs: Array,
    });

    const form = useForm({
        _method: "PUT",
        card_number: props.card.data.card_number,
        card_validity: props.card.data.card_validity.db.short,
        card_limit: props.card.data.card_limit.amount * 1,
        card_status: props.card.data.card_status,
        card_type: props.card.data.card_type,
        daily_limit: props.card.data.daily_limit?.amount * 1,
        per_transaction_limit: props.card.data.per_transaction_limit?.amount * 1,
        card_fees: props.card.data.card_fees.amount * 1,
    });

    const submit = () => {
        form._method = 'PUT'

        form.put(route('customers.cards.update', {customer: props.customer.data, card: props.card.data}), {
            preserveState: true,
            onSuccess: () => {
                ElMessage.success(usePage().props?.flash?.success)

                modalOnClose()
            },
            onError: () => {},
        })

    }

</script>

<template>
    <AppLayout :title="$t('Card Requests')">
            
        <ProfileHeader :customer="customer.data" :breadcrumbs="breadcrumbs" :card="card.data" />

        <div class="my-6">
            <div class="mx-10">

                <form action="" class="space-y-4">
                    <div class="bg-white space-y-4 rounded border p-6">
                        <h5 class="mb-5 text-xl font-bold px-10">Edit card</h5>
                        
                        <FieldGroup :inline="false" id="card_number" :placeholder="$t('Card Number')" :input-error="form.errors.card_number" v-slot="slotProps">
                            <el-input disabled :placeholder="slotProps.placeholder" v-model="form.card_number" class="w-full" size="large" />
                        </FieldGroup>

                        <FieldGroup :inline="false" id="card_validity" :placeholder="$t('Validity')" :input-error="form.errors.card_validity" v-slot="slotProps">
                            <div>
                                <el-date-picker
                                    v-model="form.card_validity"
                                    type="date"
                                    placeholder="Select expired date"
                                    class="w-full" size="large"
                                    format="DD/MM/YYYY"
                                    value-format="YYYY-MM-DD"
                                />
                            </div>
                        </FieldGroup>

                        <div class="grid grid-cols-2 gap-4">
                            <FieldGroup :inline="false" id="card_limit" :placeholder="$t('Card Limit')" :input-error="form.errors.card_limit" v-slot="slotProps">
                                <el-input :placeholder="slotProps.placeholder" v-model="form.card_limit" class="w-full" size="large">
                                    <template #prepend>USD</template>
                                </el-input>
                            </FieldGroup>

                            <FieldGroup :inline="false" id="daily_limit" :placeholder="$t('Daily Limit')" :input-error="form.errors.daily_limit" v-slot="slotProps">
                                <el-input :placeholder="slotProps.placeholder" v-model="form.daily_limit" class="w-full" size="large">
                                    <template #prepend>USD</template>
                                </el-input>
                            </FieldGroup>

                            <FieldGroup :inline="false" id="per_transaction_limit" :placeholder="$t('Limit Per Transaction')" :input-error="form.errors.per_transaction_limit" v-slot="slotProps">
                                <el-input :placeholder="slotProps.placeholder" v-model="form.per_transaction_limit" class="w-full" size="large">
                                    <template #prepend>USD</template>
                                </el-input>
                            </FieldGroup>
                        </div>

                        <FieldGroup :inline="false" id="card_type" :placeholder="$t('Card Type')" :input-error="form.errors.card_type" v-slot="slotProps">
                            <div>
                                <el-radio-group v-model="form.card_type">
                                    <el-radio label="virtual" size="default">{{ $t('Virtual') }}</el-radio>
                                    <el-radio label="physical" size="default">{{ $t('Physical') }}</el-radio>
                                </el-radio-group>
                            </div>
                        </FieldGroup>

                        <FieldGroup :inline="false" id="card_status" :placeholder="$t('Card Status')" :input-error="form.errors.card_status" v-slot="slotProps">
                            <div>
                                <el-radio-group v-model="form.card_status">
                                    <el-radio label="activated" size="default">{{ $t('Activated') }}</el-radio>
                                    <el-radio label="not activated" size="default">{{ $t('Not Activated') }}</el-radio>
                                    <el-radio label="frozen" size="default">{{ $t('Frozen') }}</el-radio>
                                </el-radio-group>
                            </div>
                        </FieldGroup>
                    </div>

                    <LinkButton class="px-4 py-2 space-x-2" :processing="form.processing" type="button" @click="submit">
                        <span>{{ $t('Save') }}</span>
                    </LinkButton>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
