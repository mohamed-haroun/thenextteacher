<script setup>
import {Head, Link} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "datatables.net-vue3";
import Header from "@/Components/Header.vue";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    lessons: Object
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
    <Head title="Lessons"/>
    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm h-fit" :items="['Lessons']">
                <template v-slot:divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </template>
            </v-breadcrumbs>
        </div>
    </Header>

    <div
        class="mx-5 text-sm bg-white dark:bg-gray-800 dark:text-white my-5 p-3 shadow-lg rounded-lg">
        <DataTable class="display w-full bg-white dark:bg-gray-800 dark:text-white"
                   :options="options"
        >
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Chapter</th>
                <th>Term</th>
                <th>Subject</th>
                <th>Grade</th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="lesson in lessons" :key="lesson.id">
                <td>{{ lesson.id }}</td>
                <td>
                    <Link :href="route('lessons.show', [lesson.id])"
                          class="w-full text-blue-500 dark:text-blue-300">{{ lesson.title }}
                    </Link>
                </td>
                <td>{{ lesson.chapter }}</td>
                <td>{{ lesson.term }}</td>
                <td>{{ lesson.subject.title }}</td>
                <td>{{ lesson.grade.title }}</td>
            </tr>
            </tbody>
        </DataTable>

    </div>
</template>
<style>
@import 'datatables.net-dt';
</style>
