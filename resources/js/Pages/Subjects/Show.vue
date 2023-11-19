<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Header from "@/Components/Header.vue";
import {Head, Link} from "@inertiajs/vue3";
import {ref} from "vue";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    subject: Object
})

let dialog = ref(false)
</script>

<template>
    <Head :title="subject.title"/>

    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm" active-color="error">
                <template v-slot:divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </template>

                <template #default>
                    <v-breadcrumbs-item>
                        <Link :href="route('subjects.index')">Subjects</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item disabled>
                        {{ subject.title }}
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>


            <div
                class="flex flex-col sm:flex-row gap-5 justify-center items-center bg-white dark:bg-gray-800">
                <Link class="w-fit mb-1" :href="route('subjects.edit', {subject: subject})">
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
                                Delete {{ subject.title }} subject
                            </v-card-title>
                            <v-card-text class="text-sm">
                                Are you sure to delete {{ subject.title }} subject?
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
                                <Link as="button" :href="route('subjects.destroy', {subject: subject})"
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

    <div class="md:mx-5 my-2 md:p-3 bg-white dark:bg-gray-800">

        <div class="flex flex-col md:flex-row sm:justify-between sm:space-x-6">
            <div class="basis-1 md:basis-1/2">
                <div class="px-4 sm:px-0">
                    <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Subject Details</h3>
                    <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500 dark:text-slate-300">Subject details and
                        questions.</p>
                </div>
                <div class="mt-6 border-t border-gray-100">
                    <dl class="divide-y divide-gray-300 dark:divide-gray-500">
                        <div class="px-4 py-6 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Title :</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                                {{
                                    subject.title
                                }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">For Schools :
                            </dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                                {{
                                    subject.school_lang
                                }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">No. Grades :
                            </dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">{{
                                    subject.grades.length
                                }} Grades
                            </dd>
                        </div>
                        <div class="px-4 py-6 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">No. Lesson :
                            </dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0 capitalize">
                                {{
                                    subject.lessons.length
                                }} Lessons
                            </dd>
                        </div>

                        <div class="px-4 py-6 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">No. Teachers :
                            </dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0 capitalize">
                                {{
                                    subject.teachers.length
                                }} Teachers
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="sm:basis-1/2 p-5 text-gray-900 dark:text-gray-100">
                <div>Total Number of questions:</div>
                <div class="overflow-auto hidden sm:block">
                    <ul role="list" class="divide-y divide-gray-300 dark:divide-gray-500">
                        <li class="flex justify-between gap-x-6 py-5">
                            <div class="flex min-w-0 gap-x-4">
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-100"></p>
                                    <p class="mt-1 truncate text-xs leading-5 text-gray-500 dark:text-gray-300"></p>
                                </div>
                            </div>
                            <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                <p class="text-sm leading-6 text-gray-900 dark:text-gray-100"></p>
                                <p class="mt-1 text-xs leading-5 text-gray-500 dark:text-gray-300"></p>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

</template>
