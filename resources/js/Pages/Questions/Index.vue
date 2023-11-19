<script setup>
import {Head, Link} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "datatables.net-vue3";
import Header from "@/Components/Header.vue";
import {MathJax} from "mathjax-vue3";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    questions: Array,
})

const options = {
    responsive: true,
    select: false,
    scroller: true,
    scrollX: 300,
    pagingType: "full_numbers",
    processing: true,
};

// test if the question has an equation
function equation(question) {
    return question.match(/'[^']*'/ig)
}
</script>

<template>
    <Head title="Questions"/>
    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm h-fit" :items="['Questions']">
                <template v-slot:divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </template>
            </v-breadcrumbs>
        </div>
    </Header>
    <div>
        <div class="flex flex-col-reverse sm:flex-row justify-center items-center gap-3 my-3">
            <div class="w-fit p-5 bg-white dark:bg-gray-700 dark:text-gray-100 shadow-lg">
                Total number of questions: {{ questions.length > 1000 ? Math.round(questions.length / 1000) + 'K' : questions.length }}
            </div>

            <div class="p-5 bg-white dark:bg-gray-700 dark:text-gray-100">
                <Link class="px-3 py-2 bg-blue-500 text-white rounded" :href="route('types.index')">
                    Question Types
                </Link>
            </div>
        </div>

        <div class="text-sm bg-white dark:bg-gray-800 dark:text-white mx-5 p-3 shadow-lg rounded-lg">
            <DataTable class="display w-full bg-white dark:bg-gray-800 dark:text-white"
                       :options="options"
            >
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Rating</th>
                    <th>Lesson</th>
                    <th>Subject</th>
                    <th>Grade</th>
                    <th>Term</th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="question in questions" :key="question.id">
                    <td>{{ question.id }}</td>
                    <td>
                        <Link :href="route('questions.show', [question.id])"
                              class="w-full text-blue-500 dark:text-blue-300 z-50">
                            <math-jax
                                v-if=" question.lesson.subject.title === 'Math' && !!equation(question.title)"
                                class="flex items-center font-sans"
                                :latex="question.title.replaceAll(`\'`, ` `)"
                            ></math-jax>
                            <span v-else>{{ question.title }}</span>
                        </Link>
                    </td>
                    <td>
                        {{ question.type.title }}
                    </td>
                    <td>{{ question.rating }}</td>
                    <td>{{ question.lesson.id }}</td>
                    <td>{{ question.lesson.subject.title }}</td>
                    <td>{{ question.lesson.grade.title }}</td>
                    <td>{{ question.lesson.term }}</td>
                </tr>
                </tbody>
            </DataTable>

        </div>
    </div>
</template>
<style>
@import 'datatables.net-dt';
</style>
