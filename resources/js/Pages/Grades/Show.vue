<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import {ref} from "vue";

defineOptions({
    layout: AuthenticatedLayout
})
defineProps({
    grade: Object
})

let dialog = ref(false)


</script>

<template>
    <Head :title="grade.title"/>

    <Header class="sm:mx-3">
        <div class="flex flex-row justify-between w-full">
            <v-breadcrumbs class="text-sm">
                <template #default>
                    <v-breadcrumbs-item>
                        <Link :href="route('grades.index')">Grades</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item disabled>
                        {{ grade.title }}
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-8 w-fit">
                <Link
                    class="basis-1/4 block"
                    :href="route('grades.edit', {grade: grade})">
                    <v-btn color="blue" prepend-icon="mdi-pencil">update</v-btn>
                </Link>
                <v-row justify="center" class="basis-1/4 block">
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
                            <v-card-title class="text-h5 text-red-500">
                                Delete {{ grade.title }} grade
                            </v-card-title>
                            <v-card-text>
                                Are you sure to delete {{ grade.title }} grade?
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
                                <Link as="button" :href="route('grades.destroy', {grade: grade})"
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

    <div class="sm:mx-5 sm:my-3">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 sm:gap-3 ">
            <div class=" p-2 md:p-5 shadow-lg rounded-lg bg-white dark:bg-gray-800 dark:text-gray-200">
                <h2>Grade Details</h2>
                <dl class="divide-y divide-gray-300 dark:divide-gray-500">
                    <div class="px-4 py-4 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Title :</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                            {{
                                grade.title
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">School :</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                            {{
                                grade.school
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Subjcets :</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                            {{
                                grade.subjects.length
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">students :</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                            {{
                                grade.students.length > 1000 ? grade.students.length / 1000 + "k" : grade.students.length
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 grid grid-cols-2 sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Tests :</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                            {{
                                grade.tests.length > 1000 ? grade.tests.length / 1000 + "k" : grade.tests.length
                            }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="shadow-lg rounded-lg bg-white dark:bg-gray-800">
                <div class="subjects">
                    <div class="w-full text-center mb-4">
                        <h3 class="text-lg text-white bg-blue-400 dark:bg-gray-700 dark:text-gray-100 py-4">
                            Subjects</h3>
                    </div>
                    <div class="text-center grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 mx-2">
                        <Link
                            v-if="grade.subjects.length"
                            v-for="subject in grade.subjects"
                            :href="route('grades.subject', [grade.id, subject.id])">

                            <p
                                class="py-2 md:py-3 shadow my-1 md:my-2 text-sm sm:text-md md:text-base bg-sky-100 dark:bg-sky-800/50 dark:text-gray-200 hover:text-blue-700 hover:dark:text-blue-300 hover:bg-indigo-100 hover:dark:bg-gray-600 transition-all"
                            >
                                {{ subject.title }}
                            </p>

                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
