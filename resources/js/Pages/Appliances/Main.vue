<template>
    <Head title="Appliances" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Appliances
            </h2>
        </template>
        <main>
            <div class="container">
                    <h1 class= "mx-10 py-3 text-3xl font-bold">
                        List of Appliances
                    </h1>
                    <div class="flex-grow mx-10 mt-3 p-3 rounded-lg bg-white">
                        <div class="flex items-center border border-slate-500 py-1 sm:w-1/2 md:w-2/3 lg:w-1/2 xl:w-1/3 h-12 rounded-full text-1xl text-left">
                        <div class="w-full pe-5 flex">
                        <div class="ml-5 self-center">
                            <img src="img-assets/vectors/search.svg" alt="search">
                        </div>
                            <input v-model="form.search" id="search" placeholder="Search" class="ms-5 w-full border-0 focus:ring-0">
                        </div>
                    </div>
                    </div>
                    <div class="mx-10 mt-5">
                        <Table
                            :tableHeaders="tableHeaders"
                            :tableData="this.$page.props.appliances"
                            :maxHeight="maxHeight"
                            :itemsPerPage="7"
                            :Pagenated="true"
                        >
                    </Table>
                    </div>
            </div>
            
        </main>
    </AuthenticatedLayout>
</template>
<script setup>
import Table from "@/Components/Table.vue";
import throttle from 'lodash/throttle'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    filters: {
        type: Object, // Ensure filters is an object
        default: () => ({ search: '' }) // Set a default value
    },
});
</script>
<script>
export default {
    components: {
        Table,
    },
    data() {
        return {
            form: {
                search: this.filters.search,
            },
            tableHeaders: [
                {
                    text: "Room",
                },
                {
                    text: "Type",
                },
                {
                    text: "Name",
                },
                {
                    text: "Status",
                },
            ],
            maxHeight: "max-h-92",
        };
    },
    watch: {
        'form.search': {
            handler: throttle(function () {
                this.$inertia.get('/appliances', { search: this.form.search }, { preserveState: true });
            }, 250),
        },
    },
    methods: {
        reset() {
            this.form.search = '';
        },
    },
    
};
</script>
