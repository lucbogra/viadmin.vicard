import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const loading = ref(false)

const handleFilter = (url, data = {}) => {
    loading.value = true

    let params = {};

    if (data.search) {
        params["search"] = data.search
    }

    if (data.per_page) {
        params["per_page"] = data.per_page
    }

    if (data.filter) {
        params["filter"] = data.filter
    }

    if (data.status) {
        params["status"] = data.status
    }

    if (data.sort) {
        params["sort"] = data.sort
        params["order"] = data.order == 'asc' ? 'desc' : 'asc'
    }

    router.get(url, params, {
        preserveState: true, 
        preserveScroll: true, 
        onFinish: () => {
            loading.value = false
        }
    })
}

const filterForm = (filter) => {
    return useForm({
        search: filter?.search,
        per_page: filter?.perPage,
        sort: filter?.sort,
        order: filter?.order,
        filter: filter?.filter,
        status: filter?.status,
        filtred: filter?.filtred
    })
}

export { 
    handleFilter, 
    filterForm,
    loading
}