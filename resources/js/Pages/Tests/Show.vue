<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, usePage} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import {onMounted, ref} from "vue";


defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    test: Object,
})

let dialog = ref(false)
</script>

<template>
    <Head title="Tests/"/>

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
                        {{ test.grade.title}} / {{ test.subject.title }} / {{ test.test_type.title }}
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
            <div class="flex justify-between items-center gap-5">
                <Link class="mb-1" :href="route('tests.display', {test: test})" as="button">
                    <v-btn color="blue" prepend-icon="mdi-laptop">Display</v-btn>
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
                        <v-card>
                            <v-card-title class="text-h6 text-red-500">
                                Delete {{ test.id }} test
                            </v-card-title>
                            <v-card-text class="text-sm">
                                Are you sure to delete {{ test.id }} test?
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
                                <Link as="button" :href="route('tests.destroy', {test: test})"
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

    <div class="md:mx-5 my-2 md:p-3 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="flex flex-col md:flex-row sm:justify-between sm:space-x-6">
            <div class="basis-1 md:basis-1/2">
                <div class="px-4 sm:px-0">
                    <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Test Details</h3>
                    <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500 dark:text-slate-300">Test details and
                        Lessons.</p>
                </div>
                <div class="mt-6 border-t border-gray-100">
                    <dl class="divide-y divide-gray-300 dark:divide-gray-500">
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Kind :</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0 overflow-x-hidden">
                                {{
                                    test.test_type.title
                                }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Subject :</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                                {{
                                    test.subject.title
                                }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Grade :</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0 capitalize">
                                {{
                                    test.grade.title
                                }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">User :</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                                {{
                                    test.user.first_name + ' ' + test.user.last_name
                                }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="sm:basis-1/2 p-5 text-gray-900 dark:text-gray-100">
                <div>Lessons</div>
                <div
                    v-for="lesson in test.lessons"
                    :key="lesson.id"
                    class="mt-5 bg-blue-100 dark:bg-blue-500 p-3 overflow-hidden"
                >
                    <p class="font-bold">
                        Lesson ({{ lesson.code }})/ Chapter ({{ lesson.chapter }})/ {{ lesson.term }} Term
                    </p>
                    <p>
                        {{ lesson.title }}
                    </p>

                </div>
            </div>
        </div>
    </div>
</template>
