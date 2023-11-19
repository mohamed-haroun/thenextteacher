<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, usePage, Link, router} from "@inertiajs/vue3";
import {ref} from "vue";
import Header from "@/Components/Header.vue";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    lesson: Object,
    questionTypes: Array
})

let counter = (key) => {
    let questions = usePage().props.lesson.questions;
    return questions.reduce((count, question) => {
        if (question.question_type_id === key) {
            count++
        }
        return count
    }, 0)
}

let dialog = ref(false)
</script>

<template>
    <Head :title="'Lesson ' + lesson.id + ' / ' + lesson.subject.title"/>


    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm" active-color="error">
                <template v-slot:divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </template>

                <template #default>
                    <v-breadcrumbs-item>
                        <Link :href="route('lessons.index')">Lessons</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item disabled>
                        {{ lesson.title }}
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>


            <div
                class="flex flex-col sm:flex-row gap-4 justify-center items-center bg-white dark:bg-gray-700">
                <Link class="mb-1" :href="route('lessons.edit', {lesson: lesson})">
                    <v-btn color="blue" prepend-icon="mdi-pencil">update</v-btn>
                </Link>
                <v-row justify="center">
                    <v-dialog
                        v-model="dialog"
                        persistent
                        width="500"
                    >
                        <template v-slot:activator="{ props }">
                            <v-btn
                                color="red"
                                v-bind="props"
                                prepend-icon="mdi-delete"
                            >
                                Delete
                            </v-btn>
                        </template>
                        <v-card class="dark:bg-gray-800 dark:text-gray-300">
                            <v-card-title class="text-h6 text-red-500">
                                Delete {{ lesson.title }} lesson
                            </v-card-title>
                            <v-card-text class="text-sm">
                                Are you sure to delete {{ lesson.title }} lesson?
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="error"
                                    variant="text"
                                    @click="dialog = false"
                                >
                                    Cancel
                                </v-btn>
                                <Link as="button" :href="route('lessons.destroy', {lesson: lesson})"
                                      method="delete">
                                    <v-btn
                                        color="green-darken-1"
                                        variant="text"
                                        @click="dialog = false"
                                    >
                                        Agree
                                    </v-btn>
                                </Link>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-row>
            </div>
        </div>
    </Header>

    <div class="md:mx-5 my-2 md:p-3 bg-white dark:bg-gray-800 shadow-lg rounded-lg">

        <div class="flex flex-col md:flex-row sm:justify-between sm:space-x-6">
            <div class="basis-1 md:basis-1/2">
                <div class="px-4 sm:px-0">
                    <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Lesson Details</h3>
                    <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500 dark:text-slate-300">Lesson details and
                        questions.</p>
                </div>
                <div class="mt-6 border-t border-gray-100">
                    <dl class="divide-y divide-gray-300 dark:divide-gray-500">
                        <div class="px-4 py-6 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0 items-center">
                            <dt class="md:text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Title :</dt>
                            <dd class="mt-1 md:text-sm leading-6 text-gray-700 dark:text-gray-100 col-span-3 sm:col-span-2 sm:mt-0">
                                {{
                                    lesson.title
                                }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0 items-center">
                            <dt class="md:text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Chapter :
                            </dt>
                            <dd class="mt-1 md:text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                                {{
                                    lesson.chapter
                                }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0 items-center">
                            <dt class="md:text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Subject :
                            </dt>
                            <dd class="mt-1 md:text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                                {{
                                    lesson.subject.title
                                }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0 items-center">
                            <dt class="md:text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Term :</dt>
                            <dd class="mt-1 md:text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0 capitalize">
                                {{
                                    lesson.term
                                }} term
                            </dd>
                        </div>
                        <div class="px-4 py-6 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0 items-center">
                            <dt class="md:text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Grade :</dt>
                            <dd class="mt-1 md:text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                                {{
                                    lesson.grade.title
                                }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0 items-center">
                            <dt class="md:text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">School :</dt>
                            <dd class="mt-1 md:text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0 capitalize">
                                {{ lesson.grade.school }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="sm:basis-1/2 p-5 text-gray-900 dark:text-gray-100">
                <div class="flex flex-col lg:flex-row space-y-5 lg:space-y-0  justify-between">
                    <p>Total Number of questions: {{ lesson.questions.length }}</p>
                    <div>
                        <Link :href="route('questions.create', {lesson:lesson.id})">
                            <v-btn class="font-bold hover:bg-green-700" color="success" prepend-icon="mdi-plus-thick">Question</v-btn>
                        </Link>
                    </div>
                </div>
                <div class="overflow-auto">
                    <ul role="list" class="divide-y divide-gray-300 dark:divide-gray-500">
                        <li class="flex justify-between py-5" v-for="type in questionTypes" :key="type.id">
                            <div class="flex min-w-0">
                                <div class="min-w-0 flex justify-start items-center gap-1">
                                    <p class="text-sm sm:text-base truncate text-gray-500 dark:text-gray-300">
                                        {{ type.title }}</p>
                                </div>
                            </div>
                            <div class="shrink-0 flex  items-center space-x-6">
                                <p class="text-sm leading-6 text-gray-900 dark:text-gray-100">{{ counter(type.id) }}</p>
                                <p class="text-sm leading-5 text-gray-500 dark:text-gray-300">
                                    {{ counter(type.id) > 1 ? 'Questions' : "Question" }}</p>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>


</template>
