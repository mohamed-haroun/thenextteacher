<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import DataTable from "datatables.net-vue3";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    teachers: Array
})

const options = {
    responsive: true,
    select: false,
    scroller: true,
    scrollX: 300,
    pagingType: "full_numbers",
    processing: true,
};
</script>

<template>
    <Head title="Teachers"/>

    <Header class="mx-3">
        <v-breadcrumbs class="text-sm">
            <template #default>
                <v-breadcrumbs-item>
                    <Link :href="route('users.index')">Users</Link>
                </v-breadcrumbs-item>
                <v-breadcrumbs-divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </v-breadcrumbs-divider>
                <v-breadcrumbs-item disabled>
                    Teachers
                </v-breadcrumbs-item>
            </template>
        </v-breadcrumbs>
    </Header>

    <div
        class="w-11/12 mx-auto text-sm bg-white dark:bg-gray-800 dark:text-white shadow hover:shadow-lg transition-all my-3 p-3">
        <DataTable class="display nowrap w-full bg-white dark:bg-slate-800 dark:text-white"
                   :options="options"
        >
            <thead>
            <tr class="py-5">
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Birth Date</th>
                <th>Gender</th>
                <th>Phone Number</th>
                <th>Governorate</th>
                <th>City</th>
                <th>Subject</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="teacher in teachers" :key="teacher.id">
                <td>{{ teacher.id }}</td>
                <td>
                    <Link :href="route('teachers.show', [teacher.id])"
                          class="w-full text-blue-500 dark:text-blue-300 z-50">{{ teacher.user.first_name }}
                    </Link>
                </td>
                <td>{{ teacher.user.last_name }}</td>
                <td>{{ teacher.user.birth_date }}</td>
                <td>{{ teacher.user.gender }}</td>
                <td>{{ teacher.user.phone_number }}</td>
                <td>{{ teacher.user.governorate }}</td>
                <td>{{ teacher.user.city }}</td>
                <td>{{ teacher.subject.title }}</td>
            </tr>
            </tbody>
        </DataTable>

    </div>

</template>
<style>
@import 'datatables.net-dt';
</style>
