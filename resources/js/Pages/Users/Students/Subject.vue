<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import {ref} from "vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";

let props = defineProps({
    lessons: Array,
    subject: Object,
    grade: Object,
    testTypes: Array
})

defineOptions({
    layout: AuthenticatedLayout
})

let term = ref('first')
let allowedTestType = ref('quiz')

let lessonsOfTerm = () => {
    return props.lessons.filter((lesson) => {
        if (lesson.term === term.value) {
            return lesson
        }
    });
}

let allowedTestTypes =() => {

    return props.testTypes.filter((testType) => {
        if (testType.title === allowedTestType.value) {
            return testType
        }
    })
}

const chapters = (lessons, term) => {
    return lessons.map(lesson => {
        if (lesson.term === term) {
            return lesson.chapter
        }
    }).filter((current, index, array) => {
        if (current !== undefined) {
            return index === array.indexOf(current);
        }
    }).sort();
}

let itemProps = (item) => {
    return {
        title: item.title,
    }
}

let form = useForm({
    grade: props.grade.title,
    subject: props.subject.title,
    lessons: '',
    type: '',
    duration: 20,
    degree: 20
})

let submit = () => {
    form.post(route('tests.store'))
}

</script>

<template>

    <Head :title="subject.title"/>

    <Header class="sm:mx-3">
        <div class="flex flex-col sm:flex-row justify-between items-center">

            <v-breadcrumbs class="text-sm">
                <template #default>
                    <v-breadcrumbs-item>
                        <Link :href="route('profile')">
                            Profile
                        </Link>
                    </v-breadcrumbs-item>

                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>

                    <v-breadcrumbs-item disabled>
                        {{ subject.title }}
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </div>
    </Header>

        <div v-if="!!lessons.length" >
            <div class="sm:mx-5 flex justify-between gap-8">
                <div  class="w-1/2 bg-white dark:bg-slate-800 dark:text-slate-300 rounded-lg shadow-md">
                    <h1 class="capitalize text-2xl font-bold bg-teal-500 dark:bg-teal-700 text-gray-50 dark:text-gray-200 text-center w-full p-5 rounded-t-lg">
                        {{ term }} Term
                    </h1>
                    <div class="px-5 py-2">
                        <div class="my-4" v-for="chapter in chapters(lessons, term)" :key="chapter">
                            <h3 class="text-xl font-bold mb-2 text-blue-600 dark:text-blue-400">Chapter {{ chapter }}</h3>
                            <div v-for="item in lessons" :key="item.id">
                                <p v-if="item.chapter === chapter && item.term === term" class="py-2 text-gray-700 dark:text-gray-300">
                                    <span class="text-orange-600 dark:text-orange-400 font-bold text-base">
                                        Lesson ( {{ item.code }} ) :
                                    </span>
                                    {{ item['title'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-1/2 p-5 rounded-lg dark:text-gray-300 dark:bg-gray-800 border-4 border-dashed border-gray-500 dark:border-gray-400">
                    <div>
                        <h3 class="text-2xl mb-3 underline text-indigo-600 dark:text-indigo-400 underline-offset-4 font-bold">
                            Quiz Details
                        </h3>
                        <div class="grid grid-cols-3 gap-2">
                            <p>- Total Mark</p>
                            <p class="col-span-2">
                                20 degree
                            </p>

                            <p>- Total questions</p>
                            <p class="col-span-2">
                                20 questions
                            </p>

                            <p>- Pass Degree</p>
                            <p class="col-span-2">
                                12 questions
                            </p>

                            <p>- Question Types</p>
                            <p class="col-span-2">
                                MCQ and Complete or True/False
                            </p>

                            <p>- Quiz Time</p>
                            <p class="col-span-2">
                                15 minutes
                            </p>

                            <p>- Exam Fee</p>
                            <p class="col-span-2">
                                20 L.E
                            </p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="text-2xl mb-3 underline text-indigo-600 dark:text-indigo-400 underline-offset-4 font-bold">
                            Instructions
                        </h3>
                        <div class="space-y-3">
                            <p>1. Don't reload the Page,</p>
                            <p>2. Don't open the new tab,</p>
                            <p>3. Don't minimize the browser,</p>
                            <p>4. Submit within the time,</p>
                            <p>5. While the time is finished exam will automatically  submit;</p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <div>
                            <v-dialog width="500">
                                <template v-slot:activator="{ props }">
                                    <v-btn v-bind="props" class="bg-blue-500 text-white font-semibold"
                                           prepend-icon="mdi-plus-thick" text="Attend Quiz"></v-btn>
                                </template>

                                <template v-slot:default="{ isActive }">
                                    <v-card title="Create New Quiz" class="dark:bg-gray-700 dark:text-blue-500">
                                        <v-card-text>
                                            <v-form @submit.prevent="submit">
                                                <div class="mt-3">
                                                    <v-select
                                                        class="dark:text-white dark:bg-gray-800 font-bold rounded-lg"
                                                        :closable-chips="true"
                                                        :chips="true"
                                                        :items="lessonsOfTerm()"
                                                        :item-props="itemProps"
                                                        label="Lessons"
                                                        v-model="form.lessons"
                                                        variant="outlined"
                                                        multiple
                                                    ></v-select>
                                                    <InputError class="mt-2" :message="form.errors.lessons"/>
                                                </div>

                                                <div>
                                                    <InputLabel for="type" value="Test Type"/>
                                                    <select
                                                        name="type"
                                                        id="type"
                                                        v-model="form.type"
                                                        placeholder="Select The type of test"
                                                        class="block border dark:text-gray-400 rounded mt-1 bg-white dark:bg-gray-900">
                                                        <option
                                                            v-for="(testType, index) in allowedTestTypes()"
                                                            :value="testType"
                                                            class="text-gray-600 dark:text-gray-400 p-5 my-3 block"
                                                            :key="testType.id"
                                                        >
                                                            {{ testType.title + ' ' }} {{ index + 1 }}
                                                        </option>
                                                    </select>
                                                    <InputError class="mt-2" :message="form.errors.type"/>
                                                </div>

                                                <div class="mt-3">
                                                    <button
                                                        type="submit"
                                                        class="px-3 py-2 text-white bg-blue-500 dark:bg-blue-500/80 rounded w-full"
                                                    >Create
                                                    </button>
                                                </div>
                                            </v-form>
                                        </v-card-text>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>

                                            <v-btn
                                                class="bg-red-500 text-white font-bold"
                                                text="Cancel"
                                                @click="isActive.value = false"
                                            ></v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </template>
                            </v-dialog>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="flex justify-center items-center h-24 md:h-96">
            <p class="text-red-500">No Lessons in this subject yet</p>
        </div>

</template>
