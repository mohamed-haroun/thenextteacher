<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    tests: Object,
    types: Array,
    examCount: Number,
    quizCount: Number,
    revisionCount: Number,
})

let snackbar = true;
</script>

<template>
    <Head title="Tests"/>

    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">

            <v-breadcrumbs class="text-sm h-fit" :items="['Tests']">
                <template v-slot:divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </template>
            </v-breadcrumbs>

            <div>
                <Link :href="route('tests.create')"
                      class="text-white bg-blue-500 hover:bg-blue-700 text-lg px-3 py-2 rounded shadow">
                    Generate
                    <v-icon size="extra-small" icon="mdi-auto-fix"/>
                </Link>
            </div>
        </div>
    </Header>

    <div v-if="$page.props.flash.message">
        <v-snackbar
            v-model="snackbar"
            location="top"
            color="success"
            variant="tonal"
        >
            <template #default>
                <p class="font-bold ">
                    <v-icon icon="mdi-check" />
                    {{ $page.props.flash.message }}
                </p>
            </template>
        </v-snackbar>
    </div>

    <div class="my-3 sm:my-5 sm:mx-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 items-center gap-5">
            <div class="bg-white dark:bg-gray-700 w-full h-full shadow-lg p-3 rounded-lg">
                <div
                    class="text-blue-500 dark:text-blue-300 border-b border-gray-600 dark:border-gray-300 p-3 flex items-center space-x-3">
                    <v-icon icon="mdi-note-text"/>
                    <h2 class="text-2xl font-black">Total Tests</h2>
                </div>
                <div class="text-center p-5 flex justify-evenly items-center dark:text-blue-50">
                    <div class="text-lg">
                        {{ tests.data.length }}
                    </div>
                    <div class="font-bold">
                        Test
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-700 w-full h-full shadow-lg p-3 rounded-lg">
                <div
                    class="text-fuchsia-600 dark:text-fuchsia-400 border-b border-gray-600 dark:border-gray-300 p-3 flex items-center space-x-3">
                    <v-icon icon="mdi-xamarin"/>
                    <h2 class="text-2xl font-black">Exams</h2>
                </div>
                <div class="text-center p-5 flex justify-evenly items-center dark:text-fuchsia-50">
                    <div class="text-lg">
                        {{ examCount }}
                    </div>
                    <div class="font-bold">
                        Exam
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-700 w-full h-full shadow-lg p-3 rounded-lg">
                <div
                    class="text-teal-500 dark:text-teal-300 border-b border-gray-600 dark:border-gray-300 p-3 flex items-center space-x-3">
                    <v-icon icon="mdi-qi"/>
                    <h2 class="text-2xl font-black">Quizzes</h2>
                </div>
                <div class="text-center p-5 flex justify-evenly items-center dark:text-teal-50">
                    <div class="text-lg">
                        {{ quizCount }}
                    </div>
                    <div class="font-bold">
                        Quiz
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-700 w-full h-full shadow-lg p-3 rounded-lg">
                <div
                    class="text-gray-500 dark:text-gray-300 border-b border-gray-600 dark:border-gray-300 p-3 flex items-center space-x-3">
                    <v-icon icon="mdi-replay"/>
                    <h2 class="text-2xl font-black">Revisions</h2>
                </div>
                <div class="text-center p-5 flex justify-evenly items-center dark:text-teal-50">
                    <div class="text-lg">
                        {{ revisionCount }}
                    </div>
                    <div class="font-bold">
                        Revision
                    </div>
                </div>
            </div>

        </div>

        <div class="my-5">
            <div class="flex justify-between items-start gap-3 my-4">
                <v-table class="hidden shadow-lg basis-2/3 md:block dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <thead>
                    <tr>
                        <th class="text-left dark:text-white font-bold">
                            #
                        </th>
                        <th class="text-left dark:text-white font-bold">
                            Type
                        </th>
                        <th class="text-left dark:text-white font-bold">
                            Subject
                        </th>
                        <th class="text-left dark:text-white font-bold">
                            Grade
                        </th>
                        <th class="text-left dark:text-white font-bold">
                            Creator
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="test in tests.data"
                        :key="test.id"
                    >
                        <td>{{ test.id }}</td>
                        <td>
                            <Link
                                class="text-blue-500"
                                :href="route('tests.show', {test: test})">
                                {{ test.test_type.title }}
                            </Link>
                        </td>
                        <td>{{ test.subject.title }}</td>
                        <td>{{ test.grade.title }}</td>
                        <td>
                            <Link class="text-blue-400 hover:underline underline-offset-4"
                                  :href="route('users.show', {user: test.user})">
                                {{ test.user.first_name }}
                            </Link>
                        </td>
                    </tr>
                    </tbody>
                </v-table>

                <div class="w-full md:w-auto md:basis-1/3 space-y-4">
                    <div class="bg-white dark:bg-gray-700 h-full shadow-lg p-3 rounded-lg">
                        <div
                            class="text-cyan-700 dark:text-cyan-500 border-b border-gray-600 dark:border-gray-300 p-3 flex items-center space-x-3">
                            <v-icon icon="mdi-palette-swatch"/>
                            <h2 class="text-2xl font-black">Types</h2>
                        </div>
                        <div class="text-center my-3">
                            <Link :href="route('testTypes.index')" class="text-blue-500 dark:text-blue-400">
                                Show
                                <v-icon icon="mdi-share"/>
                            </Link>
                        </div>
                    </div>
                </div>

            </div>

            <div class="md:hidden flex flex-col gap-3 border-t-2 py-3 mb-32">
                <div class="bg-white shadow-lg dark:bg-gray-700 dark:text-white p-4 rounded-lg space-y-3" v-for="test in tests.data" :key="test.id">
                    <p class="flex justify-start items-center">
                        <span class="basis-1/2">ID :</span>
                        <span>{{ test.id }}</span>
                    </p>
                    <p class="flex justify-start items-center">
                        <span class="basis-1/2">Type :</span>
                        <span>{{ test.test_type.title }}</span>
                    </p>
                    <p class="flex justify-start items-center">
                        <span class="basis-1/2">Subject :</span>
                        <span>{{ test.subject.title }}</span>
                    </p>
                    <p class="flex justify-start items-center">
                        <span class="basis-1/2">Grade :</span>
                        <span>{{ test.grade.title }}</span>
                    </p>
                    <p class="flex justify-start items-center">
                        <span class="basis-1/2">Creator :</span>
                        <span>
                            <Link class="text-blue-400 hover:underline underline-offset-4"
                                  :href="route('users.show', {user: test.user})">
                                {{ test.user.first_name }}
                            </Link>
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="absolute sm:right-3 bottom-3">
            <div v-if="tests.links.length > 3">
                <div class="flex flex-wrap mt-8">
                    <template v-for="(link, key) in tests.links" :key="key">
                        <div
                            v-if="link.url === null"
                            class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                            v-html="link.label"
                        />

                        <Link
                            v-else
                            class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary"
                            :class="{ 'bg-blue-500 text-white': link.active, 'bg-white text-blue-500': link.active === false}"
                            :href="link.url"
                            v-html="link.label"
                            preserve-scroll
                        />
                    </template>
                </div>
            </div>
        </div>

    </div>

</template>
