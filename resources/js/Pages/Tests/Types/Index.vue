<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router, useForm} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import DataTable from "datatables.net-vue3";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    types: Array,
})

const options = {
    responsive: true,
    select: false,
    scroller: true,
    scrollX: 300,
    autoWidth: true,
    pagingType: "full_numbers",
    processing: true,
    stateSave: true
};
</script>

<template>
    <Head title="Test/Types"/>

    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm">
                <template #default>
                    <v-breadcrumbs-item>
                        <Link :href="route('tests.index')">Tests</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item disabled>
                        Types
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
            <div>
                <Link :href="route('testTypes.create')"
                      class="text-white bg-blue-500 hover:bg-blue-700 text-sm sm:text-lg px-3 py-2 rounded shadow">
                    <v-icon size="small" icon="mdi-plus"/>
                    New Type
                </Link>
            </div>
        </div>
    </Header>

    <div class="md:mx-5">
        <div
            class="hidden md:block w-full shadow text-base bg-white dark:bg-gray-800 dark:text-white mx-auto p-3">
            <DataTable class="display bg-white dark:bg-gray-800 dark:text-white border"
                       :options="options"
            >
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>Grade</th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="type in types" :key="type.id">
                    <td>{{ type.id }}</td>
                    <td>
                        <Link :href="route('testTypes.show', [type.id])"
                              class="w-full text-blue-500 dark:text-blue-300 z-50">{{ type.title }}
                        </Link>
                    </td>
                    <td>{{ type.subject.title }}</td>
                    <td>{{ type.grade.title }}</td>
                </tr>
                </tbody>
            </DataTable>
        </div>
    </div>
</template>
<style>
@import 'datatables.net-dt';
</style>
