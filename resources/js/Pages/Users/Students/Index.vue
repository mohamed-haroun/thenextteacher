<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import DataTable from "datatables.net-vue3";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    students: Array
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
    <Head title="Students"/>

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
                    Students
                </v-breadcrumbs-item>
            </template>
        </v-breadcrumbs>
    </Header>

    <div
        class="w-11/12 mx-auto text-sm bg-white dark:bg-gray-800 dark:text-white shadow hover:shadow-lg transition-all my-3 p-3">
        <DataTable class="display nowrap bg-white dark:bg-slate-800 dark:text-gray-300"
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
                <th>Grade</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="student in students" :key="student.id">
                <td>{{ student.id }}</td>
                <td>
                    <Link :href="route('students.show', [student.id])"
                          class="w-full text-blue-500 dark:text-blue-300 z-50">{{ student.user.first_name }}
                    </Link>
                </td>
                <td>{{ student.user.last_name }}</td>
                <td>{{ student.user.birth_date }}</td>
                <td>{{ student.user.gender }}</td>
                <td>{{ student.user.phone_number }}</td>
                <td>{{ student.user.governorate }}</td>
                <td>{{ student.user.city }}</td>
                <td>{{ student.grade.title }}</td>
            </tr>
            </tbody>
        </DataTable>

    </div>
</template>
<style>
@import 'datatables.net-dt';
</style>
